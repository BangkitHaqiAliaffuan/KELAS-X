<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    /**
     * Menambahkan alamat baru ke database
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function add(Request $request)
    {
        // Validasi data input
        $request->validate([
            'address_name' => 'required',
            'recipient_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        // Gabungkan semua informasi alamat menjadi satu string
        $alamatLengkap = "Nama: {$request->address_name}, Penerima: {$request->recipient_name}, Telepon: {$request->phone}, Alamat: {$request->address}, Kota: {$request->city}, Kode Pos: {$request->postal_code}" .
            ($request->notes ? ", Catatan: {$request->notes}" : "");

        // Simpan alamat ke database dalam satu kalimat
        Alamat::create([
            'user_id' => Auth::id(),
            'alamat' => $alamatLengkap
        ]);

        // Redirect dengan pesan sukses
        return redirect('cart')->with('success', 'Alamat berhasil ditambahkan');
    }

    public function getAddressesForCart()
    {
        // Ambil alamat untuk ditampilkan di halaman cart
        $addresses = Alamat::where('user_id', Auth::id())->get();

        // Proses string alamat menjadi object untuk tampilan
        $formattedAddresses = [];

        foreach ($addresses as $address) {
            // Parse string alamat menjadi komponen-komponen
            $addressParts = $this->parseAddressString($address->alamat);

            // Tambahkan ID dan data lain yang diperlukan
            $addressParts['id'] = $address->id;
            $addressParts['is_default'] = $address->is_default ?? false;

            $formattedAddresses[] = (object) $addressParts;
        }

        return $formattedAddresses;
    }

    public function getAddressById($id)
    {
        // Ambil alamat dari database
        $address = Alamat::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$address) {
            return null;
        }

        // Parse string alamat menjadi komponen-komponen
        $addressParts = $this->parseAddressString($address->alamat);

        // Tambahkan ID dan data lain yang diperlukan
        $addressParts['id'] = $address->id;
        $addressParts['is_default'] = $address->is_default ?? false;

        return (object) $addressParts;
    }

    private function parseAddressString($addressString)
    {
        $result = [
            'name' => '',
            'recipient_name' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'postal_code' => '',
            'notes' => ''
        ];

        // Parsing string alamat
        if (
            preg_match(
                '/Nama: (.*?), Penerima: (.*?), Telepon: (.*?), Alamat: (.*?), Kota: (.*?), Kode Pos: (.*?)(?:, Catatan: (.*?))?$/',
                $addressString,
                $matches
            )
        ) {
            $result['name'] = $matches[1] ?? '';
            $result['recipient_name'] = $matches[2] ?? '';
            $result['phone'] = $matches[3] ?? '';
            $result['address'] = $matches[4] ?? '';
            $result['city'] = $matches[5] ?? '';
            $result['postal_code'] = $matches[6] ?? '';
            $result['notes'] = $matches[7] ?? '';
        }

        return $result;
    }
}
