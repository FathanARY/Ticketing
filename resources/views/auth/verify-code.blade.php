<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code - Gateway To PTN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Wendy+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-signup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-code.css') }}">
    
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
                    <h1 class="login-title font-3">Verifikasi Kode</h1>
                    <p style="color: #d1cfcfff; font-size: 14px; margin-top: 10px;">
                        Masukkan kode 6 digit yang telah dikirim ke email Anda
                    </p>
                </div>
                
                <div class="login-content">
                    @if(session('success'))
                        <div class="success-box">
                            ✓ {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Info Box with Email -->
                    <div class="info-box">
                        <p>Kode verifikasi telah dikirim ke: <span class="email">{{ session('email') }}</span></p>
                        <p class="timer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2" fill="none"/>
                                <path d="M12 6v6l4 2" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Kode berlaku selama 15 menit
                        </p>
                    </div>
                    
                    <form method="POST" action="{{ route('password.verify.post') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        
                        <div class="input-group font-1">
                            <input 
                                type="text" 
                                class="input-field code-input" 
                                placeholder="000000"
                                name="code" 
                                maxlength="6"
                                pattern="[0-9]{6}"
                                required
                                autofocus
                                inputmode="numeric"
                            >
                            @error('code')
                                <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px; display: block; text-align: center;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="login-button font-1">
                            Verifikasi Kode
                        </button>
                    </form>
                    
                    <div class="resend-link">
                        Tidak menerima kode? 
                        <form method="POST" action="{{ route('password.send-code') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <button type="submit">Kirim Ulang</button>
                        </form>
                    </div>
                </div>
                
                <div class="form-links">
                    <a href="{{ route('password.request') }}" class="forgot-password" style="text-decoration: none;">
                        Gunakan email lain
                    </a>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <span>Privacy Policy</span>
            <span>© Gateway to PTN 2025</span>
        </div>
    </div>

    <script>
        const codeInput = document.querySelector('.code-input');
        codeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length === 6) {
                this.form.submit();
            }
        });
    </script>
</body>
</html>