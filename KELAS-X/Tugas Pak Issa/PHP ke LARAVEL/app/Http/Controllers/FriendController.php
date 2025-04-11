<?php
namespace App\Http\Controllers;

use App\Helpers\AvatarHelper;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Menampilkan halaman friends berdasarkan view (manage, requests, atau add).
     */
    public function index(Request $request)
{
    // Ambil view dari query string, default ke 'manage'
    $view = $request->query('view', 'manage');
    $currentUserId = Auth::id();
    $search = $request->query('search');

    // Hitung jumlah permintaan pertemanan yang pending
    $pendingCount = Friend::where('friend_id', $currentUserId)
        ->where('status', 'pending')
        ->count();

    // Inisialisasi variabel untuk menghindari undefined variable di view
    $friends = collect();
    $requests = collect();
    $users = collect();

    if ($view == 'manage') {
        // Ambil daftar teman yang diterima (accepted)
        $friendships = Friend::where(function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)
                  ->orWhere('friend_id', $currentUserId);
        })
        ->where('status', 'accepted')
        ->with(['user', 'friend'])
        ->get();

        $friends = $friendships->map(function ($friendship) use ($currentUserId) {
            return $friendship->user_id == $currentUserId ? $friendship->friend : $friendship->user;
        });

        // Jika ada pencarian, filter teman berdasarkan username
        if ($search) {
            $friends = $friends->filter(function ($friend) use ($search) {
                return stripos($friend->username, $search) !== false;
            });
        }
    } elseif ($view == 'requests') {
        // Ambil permintaan pertemanan yang diterima oleh pengguna saat ini
        $requests = Friend::where('friend_id', $currentUserId)
            ->where('status', 'pending')
            ->with('user') // Pengirim permintaan
            ->get();

        // Jika ada pencarian, filter permintaan pertemanan berdasarkan username
        if ($search) {
            $requests = $requests->filter(function ($request) use ($search) {
                return stripos($request->user->username, $search) !== false;
            });
        }
    } elseif ($view == 'add') {
        // Ambil ID teman dan permintaan pertemanan yang sudah ada
        $friendsAndPending = Friend::where('user_id', $currentUserId)
            ->pluck('friend_id')
            ->merge(
                Friend::where('friend_id', $currentUserId)
                    ->pluck('user_id')
            );

        // Query untuk mencari pengguna yang belum berteman
        $query = User::where('id', '!=', $currentUserId)
            ->whereNotIn('id', $friendsAndPending);

        // Jika ada kata kunci pencarian, tambahkan filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Eksekusi query dan urutkan berdasarkan username
        $users = $query->orderBy('username', 'asc')->get();
    }

    // Kirim data ke view
    return view('friends', compact('view', 'pendingCount', 'friends', 'requests', 'users', 'search'));
}
    /**
     * Menangani aksi seperti add, accept, reject, dan remove.
     */
    public function handleAction(Request $request)
    {
        $action = $request->input('action');
        $friendId = $request->input('friend_id');
        $currentUserId = Auth::id();

        switch ($action) {
            case 'add':
                // Cek apakah hubungan sudah ada
                $exists = Friend::where(function ($query) use ($currentUserId, $friendId) {
                    $query->where('user_id', $currentUserId)
                          ->where('friend_id', $friendId);
                })->orWhere(function ($query) use ($currentUserId, $friendId) {
                    $query->where('user_id', $friendId)
                          ->where('friend_id', $currentUserId);
                })->exists();

                if (!$exists) {
                    Friend::create([
                        'user_id' => $currentUserId,
                        'friend_id' => $friendId,
                        'status' => 'pending',
                        'created_at' => now(),
                    ]);
                    return back()->with('success', 'Permintaan pertemanan berhasil dikirim.');
                }
                return back()->with('error', 'Pertemanan sudah ada atau sedang menunggu.');

            case 'accept':
                // Terima permintaan pertemanan
                $friendRequest = Friend::where('friend_id', $currentUserId)
                    ->where('user_id', $friendId)
                    ->where('status', 'pending')
                    ->first();

                if ($friendRequest) {
                    $friendRequest->update(['status' => 'accepted']);
                    return back()->with('success', 'Permintaan pertemanan diterima.');
                }
                return back()->with('error', 'Tidak ada permintaan tertunda yang ditemukan.');

            case 'reject':
                // Tolak permintaan pertemanan
                $friendRequest = Friend::where('friend_id', $currentUserId)
                    ->where('user_id', $friendId)
                    ->where('status', 'pending')
                    ->first();

                if ($friendRequest) {
                    $friendRequest->delete();
                    return back()->with('success', 'Permintaan pertemanan ditolak.');
                }
                return back()->with('error', 'Tidak ada permintaan tertunda yang ditemukan.');

            case 'remove':
                // Hapus pertemanan
                Friend::where(function ($query) use ($currentUserId, $friendId) {
                    $query->where('user_id', $currentUserId)
                          ->where('friend_id', $friendId);
                })->orWhere(function ($query) use ($currentUserId, $friendId) {
                    $query->where('user_id', $friendId)
                          ->where('friend_id', $currentUserId);
                })->delete();

                return back()->with('success', 'Teman berhasil dihapus.');

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }
    }
}
