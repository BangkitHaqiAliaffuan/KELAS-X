<?php

namespace App\Http\Controllers;

use App\Models\UserOtp;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showVerificationForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('otp_verification', ['user' => $user]);
    }

    public function verify(Request $request, $userId)
    {
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        // Ambil user sebagai instance tunggal
        $user = User::where('id', $userId)->first();

        // Verifikasi OTP
        $otpData = UserOtp::where('user_id', $user->id)->first();

        if (!$otpData || $otpData->otp_code != $request->otp_code) {
            return back()->withErrors(['otp_code' => 'OTP tidak valid']);
        }

        if (now()->isAfter($otpData->expired_at)) {
            return back()->withErrors(['otp_code' => 'OTP sudah kadaluarsa']);
        }

        // OTP valid, hapus OTP dan login pengguna
        $otpData->delete();
            
        return redirect('/login')->with('success', 'Verifikasi berhasil');
    }
    public function generate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);

        UserOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_code' => $otp,
                'expired_at' => now()->addMinutes(5), // Konsisten dengan expired_at
            ]
        );

        Mail::to($user->email)->send(new OtpMail($user, $otp));

        return response()->json([
            'message' => 'Kode OTP telah dikirim ke email Anda',
        ]);
    }

    public function resend($userId)
    {
        $user = User::findOrFail($userId);
        $otp = rand(100000, 999999);

        UserOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp_code' => $otp,
                'expired_at' => now()->addMinutes(5),
            ]
        );

        Mail::to($user->email)->send(new OtpMail($user, $otp));

        return back()->with('message', 'OTP telah dikirim ulang.');
    }
}
