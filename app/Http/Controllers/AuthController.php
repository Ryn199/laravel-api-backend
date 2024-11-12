<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil kredensial dari input user
        $credentials = $request->only('email', 'password');

        try {
            // Attempt untuk membuat token dengan kredensial yang ada
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Mendapatkan data user yang sedang login
            $user = Auth::user();

            // Membuat token dengan informasi tambahan (username dan email)
            $customClaims = [
                'username' => $user->name,  // Menambahkan username ke dalam token
                'email' => $user->email,    // Menambahkan email ke dalam token
            ];

            // Menghasilkan token dengan claims tambahan
            $token = JWTAuth::claims($customClaims)->fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // Berikan respons dengan token yang sudah ditambahkan informasi pengguna
        return response()->json([
            'token' => $token,
        ]);
    }
}
