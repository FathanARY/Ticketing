<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Gateway To PTN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Wendy+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
</head>

<body>
    <div class="main-login font-1">
        <div class="navbar font-1">
            <div class="logo font-3">
                <a href="{{ route('home') }}">
                    <img class="GTP" src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="logo">
                    <div class="cover">
                        <div class="title">Gateway to PTN</div>
                        <div class="bottom">
                            <span class="by">by</span>
                            <span class="ie">Indomie Enak</span>
                        </div>
                </a>
            </div>
        </div>
        <div class="login-signup">
            <button type="button" onclick="window.location.href='{{ route('login') }}'">Login</button>
        </div>
        </div>
        <div class="login-container">
                <div class="login-card">
                    <div class="login-header-text">
                        <h1 class="login-title font-3">Forgot Password</h1>
                        <p style="color: var(--text-muted); font-size: 14px; margin-top: 10px;">
                            Masukkan email Anda</br>kami akan mengirimkan kode verifikasi
                        </p>
                    </div>
                    
                    <div class="login-content">
                        <form method="POST" action="{{ route('password.send-code') }}">
                            @csrf
                            
                            <div class="input-group">
                                <input 
                                    type="email" 
                                    class="input-field" 
                                    placeholder="Email"
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    autofocus
                                >
                                @error('email')
                                    <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="login-button">
                                Kirim Kode Verifikasi
                            </button>
                        </form>
                    </div>
                    
                    <div class="form-links">
                        <a href="{{ route('login') }}" class="forgot-password" style="text-decoration: none;">
                            Kembali ke Login
                        </a>
                    </div>
                </div>
<<<<<<< HEAD
        </div>

        <div class="login-footer">
            <span>Privacy Policy</span>
            <span>© Gateway to PTN 2025</span>
=======

            <div class="login-footer">
                <span>Privacy Policy</span>
                <span>© Gateway to PTN 2025</span>
            </div>
>>>>>>> fe8adb1 (forgot password)
        </div>
    </div>
</body>
</html>