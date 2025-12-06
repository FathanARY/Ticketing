<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset code to email
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $recentAttempts = DB::table('password_resets')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subHour())
            ->count();

        if ($recentAttempts >= 3) {
            return back()->withErrors(['email' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.']);
        }

        $user = DB::table('users')->where('email', $email)->first();
 
        if ($user) { 
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('password_resets')->where('email', $email)->delete();

            DB::table('password_resets')->insert([
                'email' => $email,
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(15),
                'attempts' => 0,
                'created_at' => Carbon::now()
            ]);

            try {
                Mail::to($email)->send(new PasswordResetMail($code, $user->nama_lengkap, 15));

                \Log::info('Password reset code sent', [
                    'email' => $email,
                    'code' => $code
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to send password reset email', [
                    'email' => $email,
                    'error' => $e->getMessage()
                ]);

                return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
            }
        }

        return redirect()->route('password.verify')->with([
            'email' => $email,
            'success' => 'Kode verifikasi telah dikirim ke email Anda. Silakan cek inbox atau folder spam.'
        ]);
    }

    public function showVerifyForm()
    {
        if (!session('email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        $email = $request->email;
        $code = $request->code;

        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$reset) {
            return back()->withErrors(['code' => 'Kode verifikasi tidak valid atau sudah kadaluarsa.']);
        }

        if (Carbon::parse($reset->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return back()->withErrors(['code' => 'Kode verifikasi sudah kadaluarsa. Silakan minta kode baru.']);
        }

        if ($reset->attempts >= 3) {
            DB::table('password_resets')->where('email', $email)->delete();
            return back()->withErrors(['code' => 'Terlalu banyak percobaan gagal. Silakan minta kode baru.']);
        }

        if ($reset->code !== $code) {
            DB::table('password_resets')
                ->where('email', $email)
                ->update(['attempts' => $reset->attempts + 1]);

            $remaining = 3 - ($reset->attempts + 1);
            return back()->withErrors(['code' => "Kode verifikasi salah. Sisa percobaan: {$remaining}"]);
        }

        return redirect()->route('password.reset')->with([
            'email' => $email,
            'code' => $code,
            'success' => 'Kode verifikasi benar. Silakan masukkan password baru Anda.'
        ]);
    }

    public function showResetForm()
    {
        if (!session('email') || !session('code')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $email = $request->email;
        $code = $request->code;

        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$reset) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'Sesi reset password tidak valid. Silakan mulai dari awal.']);
        }

        if (Carbon::parse($reset->expires_at)->isPast()) {
            DB::table('password_resets')->where('email', $email)->delete();
            return redirect()->route('password.request')
                ->withErrors(['error' => 'Kode sudah kadaluarsa. Silakan minta kode baru.']);
        }

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['error' => 'User tidak ditemukan.']);
        }

        DB::table('users')
            ->where('email', $email)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now()
            ]);

        DB::table('password_resets')->where('email', $email)->delete();

        \Log::info('Password reset successful', [
            'email' => $email,
            'user_id' => $user->user_id
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }

    public function resendCode(Request $request)
    {
        $email = $request->email ?? session('email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $recentCode = DB::table('password_resets')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subMinute())
            ->first();

        if ($recentCode) {
            return back()->withErrors(['error' => 'Silakan tunggu 1 menit sebelum meminta kode baru.']);
        }

        DB::table('password_resets')->where('email', $email)->delete();

        return redirect()->route('password.send-code')
            ->with('email', $email);
    }
}
