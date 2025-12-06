<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Gateway To PTN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Wendy+One&display=swap" rel="stylesheet">
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
            <ul class="navbar-content">
                <li><a href="{{ route('dashboard') }}">Kembali ke Dashboard</a></li>
            </ul>
    </div>

        <div class="signUp-container">
            <div class="signUp-card">
                <div class="signUp-header-text">
                    <h1 class="signUp-title font-3">Lengkapi Profil</h1>
                    <p style="color: #FFE3FE; font-size: 13px; margin-top: 10px;">
                        Mohon lengkapi data No. HP dan Asal Sekolah untuk keperluan tiket.
                    </p>
                </div>
                
                <div class="signUp-content">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="input-group">
                            <label style="color:gold; font-size:12px; margin-left:5px;">Nama Lengkap</label>
                            <input 
                                type="text" 
                                class="input-field" 
                                name="nama_lengkap" 
                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                                required
                            >
                        </div>

                        <div class="input-group">
                            <label style="color:gold; font-size:12px; margin-left:5px;">Email (Tidak dapat diubah)</label>
                            <input 
                                type="email" 
                                class="input-field" 
                                value="{{ $user->email }}" 
                                readonly
                                style="background: rgba(0,0,0,0.2); cursor: not-allowed;"
                            >
                        </div>

                        <div class="input-group">
                            <label style="color:gold; font-size:12px; margin-left:5px;">No. WhatsApp / HP</label>
                            <input 
                                type="text" 
                                class="input-field"
                                name="no_hp" 
                                placeholder="Contoh: 08123456789"
                                value="{{ old('no_hp', $user->no_hp) }}"
                                required
                            >
                            @error('no_hp')
                                <span style="color: #ff8a8a; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <label style="color:gold; font-size:12px; margin-left:5px;">Asal Sekolah</label>
                            <input 
                                type="text" 
                                class="input-field" 
                                name="school_name"
                                placeholder="Contoh: SMAN 1 Bandung"
                                value="{{ old('school_name', $user->school_name) }}"
                                required
                            >
                            @error('school_name')
                                <span style="color: #ff8a8a; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="login-button font-1" style="margin-top: 20px;">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>  
            </div>
        </div>

        <div class="login-footer">
            <span>© Gateway to PTN 2025</span>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach((input, index) => {
                input.style.animationDelay = `${index * 0.1}s`;
                input.classList.add('fadeIn');
            });
        });
    </script>
</body>
</html>