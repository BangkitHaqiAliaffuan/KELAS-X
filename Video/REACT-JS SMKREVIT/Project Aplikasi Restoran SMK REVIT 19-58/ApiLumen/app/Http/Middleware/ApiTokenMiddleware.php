<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'API token tidak ditemukan'
            ], 401);
        }

        // Remove 'Bearer ' from token if present
        $token = str_replace('Bearer ', '', $token);

        // Validate token and get user
        $user = $this->getValidUser($token);

        if (!$user) {
            return response()->json([
                'message' => 'API token tidak valid'
            ], 401);
        }

        // Cek status user
        if ($user->status === 0) {
            return response()->json([
                'message' => 'Akun anda tidak aktif'
            ], 403);
        }

        // Simpan user dalam request
        $request->merge(['user' => $user]);

        return $next($request);
    }

    private function getValidUser($token)
    {
        // Cek token di database dan ambil data user
        return \App\Models\User::where('api_token', $token)->first();
    }
}
