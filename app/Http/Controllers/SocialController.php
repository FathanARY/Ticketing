<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller
{
    // ==========================================
    // GOOGLE LOGIN
    // ==========================================

    public function redirectToGoogle()
    {
        // Clear any existing session state to prevent conflicts
        session()->forget('state');
        
        // Get the Socialite driver with custom Guzzle client for SSL fix
        $driver = Socialite::driver('google')->stateless();
        
        // Fix SSL certificate issue on Windows (Laragon/AMPPS)
        $certPath = storage_path('cacert.pem');
        if (file_exists($certPath)) {
            $driver->setHttpClient(new \GuzzleHttp\Client([
                'verify' => $certPath,
            ]));
        }
        
        return $driver->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $driver = Socialite::driver('google')->stateless();
            
            // Fix SSL certificate issue on Windows (Laragon/AMPPS)
            $certPath = storage_path('cacert.pem');
            if (file_exists($certPath)) {
                $driver->setHttpClient(new \GuzzleHttp\Client([
                    'verify' => $certPath,
                ]));
            }
            
            $googleUser = $driver->user();

            // 1. Cari user berdasarkan google_id
            $finduser = User::where('google_id', $googleUser->id)->first();

            if ($finduser) {
                // Jika akun sudah ada, langsung login
                Auth::login($finduser);

                if ($finduser->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('dashboard');
            } else {
                // 2. Jika google_id belum ada, cek emailnya
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Jika email sudah terdaftar manual, sambungkan google_id nya
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::login($existingUser);

                    if ($existingUser->role == 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect()->route('dashboard');
                } else {
                    // 3. USER BARU (AUTO REGISTER)
                    // No HP dan Sekolah biarkan kosong (user isi sendiri nanti di dashboard)
                    $newUser = User::create([
                        'nama_lengkap' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make('123456dummy'), // Password acak
                        'role' => 'user',
                        'no_hp' => null,
                        'school_name' => null
                    ]);

                    Auth::login($newUser);
                    return redirect()->route('dashboard');
                }
            }
        } catch (\Exception $e) {
            // Debug: uncomment line below to see actual error message
            // dd($e->getMessage());
            return redirect()->route('login')->withErrors(['email' => 'Login Google gagal: ' . $e->getMessage()]);
        }
    }

    // ==========================================
    // FACEBOOK LOGIN
    // ==========================================

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            // Facebook sudah benar pakai stateless()
            $fbUser = Socialite::driver('facebook')->stateless()->user();

            $finduser = User::where('facebook_id', $fbUser->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                if ($finduser->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('dashboard');
            } else {
                $existingUser = User::where('email', $fbUser->email)->first();

                if ($existingUser) {
                    $existingUser->update(['facebook_id' => $fbUser->id]);
                    Auth::login($existingUser);
                    if ($existingUser->role == 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect()->route('dashboard');
                } else {
                    $newUser = User::create([
                        'nama_lengkap' => $fbUser->name,
                        'email' => $fbUser->email,
                        'facebook_id' => $fbUser->id,
                        'password' => Hash::make('123456dummy'),
                        'role' => 'user',
                    ]);
                    Auth::login($newUser);
                    return redirect()->route('dashboard');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Login Facebook gagal. Pastikan setup HTTPS benar.']);
        }
    }
}
