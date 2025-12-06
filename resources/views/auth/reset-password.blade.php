<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Gateway To PTN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Wendy+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset-password.css') }}">
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

        <div class="login-containers">
            <div class="login-cards">
                <div class="login-header-text">
                    <h1 class="login-title font-3">Reset Password</h1>
                    <p style="color: #d1cfcfff; font-size: 14px; margin-top: 10px;">
                        Buat password baru untuk akun Anda
                    </p>
                </div>
                
                <div class="login-content">
                    @if(session('success'))
                        <div class="success-box">
                            ✓ {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->has('error'))
                        <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    
                    <div class="password-requirements">
                        <h4>Password harus memenuhi:</h4>
                        <ul>
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf dan angka</li>
                            <li>Tidak mudah ditebak</li>
                        </ul>
                    </div>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        <input type="hidden" name="code" value="{{ session('code') }}">
                        
                        <div class="input-group">
                            <input 
                                type="password" 
                                class="input-field" 
                                id="password"
                                placeholder="Password Baru"
                                name="password" 
                                required
                                minlength="8"
                            >
                            <span class="input-icon" onclick="togglePassword('password')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </span>
                            @error('password')
                                <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input 
                                type="password" 
                                class="input-field font-1 " 
                                id="password_confirmation"
                                placeholder="Konfirmasi Password Baru"
                                name="password_confirmation" 
                                required
                                minlength="8"
                            >
                            <span class="input-icon" onclick="togglePassword('password_confirmation')">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </span>
                        </div>

                        <button type="submit" class="login-button font-1">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <span>Privacy Policy</span>
            <span>© Gateway to PTN 2025</span>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
        
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        
        confirm.addEventListener('input', function() {
            if (password.value !== confirm.value) {
                confirm.setCustomValidity('Password tidak sama');
            } else {
                confirm.setCustomValidity('');
            }
        });
    </script>
</body>
</html>