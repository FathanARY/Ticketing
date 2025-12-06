<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway To PTN - Login</title>
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
            <button type="button" onclick="window.location.href='{{ route('register') }}'">Signup</button>
        </div>
        </div>

        <div class="login-container">
            <div class="login-card">
                <div class="login-header-text">
                    <h1 class="login-title font-3">Sign In.</h1>
                </div>
                
                <div class="login-content">
                    @if(session('success'))
                        <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background: rgba(255,100,100,0.2); color: #ff8a8a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ff5555;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="background: rgba(255,100,100,0.2); color: #ff8a8a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ff5555;">
                            @foreach($errors->all() as $error)
                                <p style="margin: 0;">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf 
                        <div class="input-group">
                          <input 
                              type="text" 
                              class="input-field" 
                              placeholder="Email"
                              name="email" 
                              value="{{ old('email') }}" 
                              required
                          >
                          @error('email')
                              <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                          @enderror
                      </div>

                      <div class="input-group">
                          <input 
                              type="password" 
                              class="input-field" 
                              id="password"
                              placeholder="Password"
                              name="password" 
                              required
                          >
                          <span class="input-icon" onclick="togglePassword()">
                              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                  <circle cx="12" cy="12" r="3"/>
                              </svg>
                          </span>
                          @error('password')
                              <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                          @enderror
                      </div>

                      <button type="submit" class="login-button">
                          Login to Your Account
                          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 10px;">
                              <path d="M5 12h14M12 5l7 7-7 7"/>
                          </svg>
                      </button>
                  </form>
                  
                  <div class="separator">
                    /
                  </div>

                    <div class="social-login">
                        <a href="{{ route('google.login') }}" class="social-button google">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Sign in with Google
                        </a>
                    </div>
                </div>
              <div class="form-links">
                  <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
              </div>
            </div>
        </div>

        <div class="login-footer">
            <span>Privacy Policy</span>
            <span>© Gateway to PTN 2025</span>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>