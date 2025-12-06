<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use Illuminate\Auth\Events\Registered; // <-- Hapus import ini

class AuthController extends Controller
{
    /**
     * Menangani proses registrasi (Signup).
     */
    public function registerStore(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'school_name'  => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        // 2. Buat user baru
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'school_name'  => $request->school_name,
            'no_hp'        => $request->no_hp,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
        ]);

        // 3. (DIHAPUS) Pemicu event kirim email
        // event(new Registered($user)); // <-- Baris ini dihapus

        // 4. (BARU) Langsung loginkan user setelah registrasi
        Auth::login($user);

        // 5. (BARU) Arahkan user ke dashboard-nya
        // Cek role untuk pengalihan
        if ($user->role == 'admin') {
            return redirect(route('admin.dashboard'));
        }
        return redirect(route('dashboard'));

        // 6. (DIHAPUS) Baris redirect ke login
        // return redirect(route('login'))
        //    ->with('success', 'Akun berhasil dibuat! Silakan cek email Anda untuk verifikasi.');
    }

    /**
     * Menangani proses login.
     */
    public function loginStore(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 2. Ambil data email & password
        $credentials = $request->only('email', 'password');

        // 3. Coba lakukan login
        if (Auth::attempt($credentials)) {
            // 4. Jika berhasil, regenerate session
            $request->session()->regenerate();

            $user = Auth::user();

            // 5. (DIHAPUS) Cek verifikasi email
            // if ($user->email_verified_at == null) { ... } // <-- Seluruh blok IF ini dihapus

            // 6. Cek role user
            if ($user->role == 'admin') {
                // Jika admin, arahkan ke dashboard admin
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika user biasa, arahkan ke dashboard user
            return redirect()->intended(route('dashboard'));
        }

        // 7. Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}