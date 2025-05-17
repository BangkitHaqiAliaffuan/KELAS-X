<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        $menus = Menu :: paginate(3);

        return view('menu', [
            'kategoris' => $kategoris,
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'pelanggan' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'jeniskelamin' => 'required',
            'email' => 'required | email | unique:pelanggans',
            'password' => 'required | min:3',

        ]);

        $pelanggan = Pelanggan::create([            'pelanggan' => $data['pelanggan'],            'jeniskelamin' => $data['jeniskelamin'],            'alamat' => $data['alamat'],            'telp' => $data['telp'],            'email' => $data['email'],            'password' => Hash::make($data['password']),            'aktif' => 0        ]);

        // Simpan email di session untuk verifikasi OTP
        session(['email_for_otp' => $data['email']]);

        // Kirim OTP
        $response = app(OtpController::class)->sendOtp(new Request(['email' => $data['email']]));

        return view('otp-verification');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategoris = Kategori::all();
        $menus = Menu :: where('idkategori',$id)->paginate(3);

        return view('kategori', [
            'kategoris' => $kategoris,
            'menus' => $menus
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register()
     {
        $kategoris = Kategori::all();
        return view('register', ['kategoris' => $kategoris]);
    }

    public function login()
    {
        $kategoris = Kategori::all();
        return view('login',['kategoris' => $kategoris]);
    }

    public function postlogin(Request $request)
    {
        $data = $request->validate([
            'email' =>'required',
            'password' =>'required | min:3',
        ]);
       $pelanggan = Pelanggan::where('email', $data['email'])->where('aktif',1)->first();

        if($pelanggan){
            if(Hash::check($data['password'],$pelanggan['password'])){
                $sessionData = [
                    'idpelanggan' => $pelanggan['idpelanggan'],
                    'email' => $pelanggan['email'],
                    'pelanggan' => $pelanggan['pelanggan'],
                    'image' => $pelanggan->image ?? null,
                    'telp' => $pelanggan['telp'],
                    'jeniskelamin' => $pelanggan['jeniskelamin'],
                    'alamat' => $pelanggan['alamat'],
                ];

                $request->session()->put('idpelanggan', $sessionData);
                return redirect('/');
            } else{
                return back()->with('pesan','Password Salah');
            }
        } else{
            return back()->with('pesan','Email Belum Terdaftar');
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function order_history()
    {
        if (session()->missing('idpelanggan')) {
            return redirect('login')->with('pesan', 'Silahkan login terlebih dahulu');
        }

        $kategoris = Kategori::all();
        $orders = Order::where('idpelanggan', session('idpelanggan')['idpelanggan'])
                      ->orderBy('tglorder', 'desc')
                      ->get();

        return view('order-history', [
            'kategoris' => $kategoris,
            'orders' => $orders
        ]);
    }

    public function order_detail($idorder)
    {
        if (session()->missing('idpelanggan')) {
            return redirect('login')->with('pesan', 'Silahkan login terlebih dahulu');
        }

        $kategoris = Kategori::all();
        $order = Order::where('idorder', $idorder)
                     ->where('idpelanggan', session('idpelanggan')['idpelanggan'])
                     ->first();

        if (!$order) {
            return redirect('order-history')->with('error', 'Pesanan tidak ditemukan');
        }

        $orderDetails = OrderDetail::where('idorder', $idorder)
                                  ->join('menus', 'order_details.idmenu', '=', 'menus.idmenu')
                                  ->select('order_details.*', 'menus.menu', 'menus.gambar')
                                  ->get();

        return view('order-detail', [
            'kategoris' => $kategoris,
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);
    }
    public function profile()
    {
        if (session()->missing('idpelanggan')) {
            return redirect('login')->with('pesan', 'Silahkan login terlebih dahulu');
        }

        $kategoris = Kategori::all();
        $pelanggan = Pelanggan::where('idpelanggan', session('idpelanggan')['idpelanggan'])->first();

        return view('profile', [
            'kategoris' => $kategoris,
            'pelanggan' => $pelanggan
        ]);
    }

    public function updateProfile(Request $request)
    {
        if (session()->missing('idpelanggan')) {
            return redirect('login')->with('pesan', 'Silahkan login terlebih dahulu');
        }

        $data = $request->validate([
            'pelanggan' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'jeniskelamin' => 'required',
            'password' => 'nullable|min:3|confirmed',
        ]);

        $pelanggan = Pelanggan::where('idpelanggan', session('idpelanggan')['idpelanggan'])->first();

        $updateData = [
            'pelanggan' => $data['pelanggan'],
            'alamat' => $data['alamat'],
            'telp' => $data['telp'],
            'jeniskelamin' => $data['jeniskelamin'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $pelanggan->update($updateData);

        // Update session data
        $sessionData = [
            'idpelanggan' => $pelanggan->idpelanggan,
            'email' => $pelanggan->email,
        ];

        if ($pelanggan->image) {
            $sessionData['image'] = $pelanggan->image;
        }

        session(['idpelanggan' => $sessionData]);

        return redirect('profile')->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePhoto(Request $request)
    {
        if (session()->missing('idpelanggan')) {
            return redirect('login')->with('pesan', 'Silahkan login terlebih dahulu');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pelanggan = Pelanggan::where('idpelanggan', session('idpelanggan')['idpelanggan'])->first();

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($pelanggan->image && file_exists(storage_path('app/public/uploads/pelanggan/' . $pelanggan->image))) {
                unlink(storage_path('app/public/uploads/pelanggan/' . $pelanggan->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $pelanggan->idpelanggan . '.' . $image->getClientOriginalExtension();

            // Pastikan direktori ada
            if (!file_exists(storage_path('app/public/uploads/pelanggan'))) {
                mkdir(storage_path('app/public/uploads/pelanggan'), 0755, true);
            }

            $image->storeAs('public/uploads/pelanggan', $imageName);

            $pelanggan->update(['image' => $imageName]);

            // Update session data
            $sessionData = session('idpelanggan');
            $sessionData['image'] = $imageName;
            session(['idpelanggan' => $sessionData]);

            return redirect('profile')->with('success', 'Foto profil berhasil diperbarui');
        }

        return redirect('profile')->with('error', 'Gagal mengupload foto');
    }
}
