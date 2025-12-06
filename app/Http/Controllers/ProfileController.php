<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // 1. Tampilkan Form Edit
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // 2. Proses Update Data
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'school_name'  => 'required|string|max:255',
            // Email sengaja tidak divalidasi untuk diubah karena ini akun Google
        ]);

        // Simpan perubahan
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp'        => $request->no_hp,
            'school_name'  => $request->school_name,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui! Sekarang Anda bisa memesan tiket.');
    }
}