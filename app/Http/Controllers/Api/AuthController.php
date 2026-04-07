<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('nip', $request->nip)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'NIP atau password salah',
            ], 401);
        }

        // Optional: cek status user
        if (isset($user->status) && strtolower($user->status) !== 'aktif') {
            return response()->json([
                'message' => 'Akun tidak aktif',
            ], 403);
        }

        $token = $user->createToken('flutter-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'nip' => $user->nip,
                'role' => $user->role,
                'unit_kerja' => $user->unit_kerja,
                'status' => $user->status,
            ],
        ], 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'nip' => $user->nip,
                'role' => $user->role,
                'unit_kerja' => $user->unit_kerja,
                'status' => $user->status,
            ],
        ], 200);
    }
}