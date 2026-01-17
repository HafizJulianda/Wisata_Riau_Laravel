<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // 🔐 REGISTRASI
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:tb_user,username',
            'password' => 'required|string|min:6',
        ]);

        $pengguna = Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data'    => [
                'id'       => $pengguna->id,
                'username' => $pengguna->username,
            ],
        ], 201);
    }

    // 🔓 LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return response()->json([
                'message' => 'Login gagal: username atau password salah',
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user'    => [
                'id'       => $pengguna->id,
                'username' => $pengguna->username,
            ],
        ]);
    }

    // 🔁 GANTI PASSWORD
    public function changePasswordWithoutOld(Request $request)
    {
        $request->validate([
            'username'     => 'required|string',
            'new_password' => 'required|string|min:6',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        $pengguna->password = Hash::make($request->new_password);
        $pengguna->save();

        return response()->json(['message' => 'Password berhasil diubah']);
    }

    // 🗑️ DELETE ACCOUNT
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $pengguna = Pengguna::where('username', $request->username)->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        $pengguna->delete();

        return response()->json(['message' => 'Akun berhasil dihapus']);
    }
}