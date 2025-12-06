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
            <button type="button" onclick="window.location.href='{{ route('login') }}'">Login</button>
        </div>
    </div> <div class="signUp-container">
        <div class="signUp-card">
            <div class="signUp-header-text">
                <h1 class="signUp-title font-3">Create Account</h1>
            </div>
            
            <div class="signUp-content">
                
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf <div class="input-group">
                      <input 
                          type="text" 
                          class="input-field" 
                          placeholder="Full Name"
                          name="nama_lengkap" 
                          value="{{ old('nama_lengkap') }}" 
                          required
                      >
                      @error('nama_lengkap')
                          <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="input-group">
                      <input 
                          type="text" 
                          class="input-field"
                          id="school-name"
                          placeholder="School Name"
                          name="school_name" 
                          value="{{ old('school_name') }}"
                          required
                      >
                      @error('school_name')
                          <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                      @enderror
                  </div>
                  
                  <div class="input-group">
                      <input 
                          type="text" 
                          class="input-field" 
                          placeholder="No. HP (e.g., 0812...)"
                          name="no_hp"
                          value="{{ old('no_hp') }}"
                          required
                      >
                      @error('no_hp')
                          <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                      @enderror
                  </div>

                  <div class="input-group">
                      <input 
                          type="email" 
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
                        </span>
                      @error('password')
                          <span style="color: #ff8a8a; font-size: 12px; margin-top: 5px;">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="input-group">
                    <input 
                        type="password" 
                        class="input-field" 
                        id="confirm-password"
                        placeholder="Confirm Password"
                        name="password_confirmation" 
                        required
                    >
                    <span class="input-icon" onclick="togglePassword()">
                        </span>
                </div>

                  <button type="submit" class="login-button">
                      Create Your Account
                      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" style="margin-left: 10px;">
                          <path d="M5 12h14M12 5l7 7-7 7"/>
                      </svg>
                  </button>
              </form>
              </div>  
        </div>
    </div>

    <div class="login-footer">
        <span>Privacy Policy</span>
        <span>© Gateway to PTN 2025</span>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>