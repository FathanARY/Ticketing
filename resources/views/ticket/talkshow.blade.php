<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Talkshow - Gateway To PTN</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ticket-dashboard.css') }}"> <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asimovian&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Wendy+One&display=swap" rel="stylesheet">
</head>

<body>
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

    <div class="dashboard-container font-1">
        <div class="content-wrapper">
            <div class="header">
                <h1 class="header-title" style="color: white; text-align: center; margin-bottom: 30px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    Pendaftaran Talkshow Inspiratif
                </h1>
            </div>

            <form method="POST" action="{{ route('ticket.talkshow.submit') }}">
                @csrf
                
                @if(session('error'))
                    <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; border: 1px solid #ef9a9a;">
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                @endif

                <div class="section-card">
                    <div class="section-header">
                        <div class="step-number">1</div>
                        <h2 class="section-title">Data Peserta</h2>
                    </div>
                    <div class="section-content">
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 13px; color: #666; font-weight: 600;">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="input-field" value="{{ Auth::user()->nama_lengkap }}" readonly style="background: #f0f0f0; color: #888;">
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 13px; color: #666; font-weight: 600;">Email (Tiket akan dikirim ke sini)</label>
                            <input type="email" name="email" class="input-field" value="{{ Auth::user()->email }}" readonly style="background: #f0f0f0; color: #888;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 13px; color: #666; font-weight: 600;">No. WhatsApp / HP</label>
                            <input type="text" name="no_hp" class="input-field" value="{{ Auth::user()->no_hp }}" required>
                        </div>

                        <div>
                            <label style="font-size: 13px; color: #666; font-weight: 600;">Asal Sekolah</label>
                            <input type="text" name="school_name" class="input-field" value="{{ Auth::user()->school_name }}" required>
                        </div>
                    </div>
                </div>

                <div class="section-card">
                    <div class="section-header">
                        <div class="step-number">2</div>
                        <h2 class="section-title">Pilih Tipe Kehadiran</h2>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        @foreach($tickets as $t)
                            <label class="bundle-card" style="text-align: center; padding: 30px 20px;">
                                <input type="radio" name="jenis_tiket" value="{{ $t->jenis_tiket }}" class="bundle-radio" required>
                                
                                <div class="bundle-content">
                                    <div class="bundle-icon" style="margin: 0 auto 15px;">
                                        @if($t->jenis_tiket == 'Talkshow Offline')
                                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        @else
                                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2">
                                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                                <line x1="12" y1="17" x2="12" y2="21"></line>
                                            </svg>
                                        @endif
                                    </div>

                                    <span class="bundle-name" style="font-size: 16px; display: block; margin-bottom: 5px;">
                                        {{ $t->jenis_tiket }}
                                    </span>
                                    
                                    @if($t->jenis_tiket == 'Talkshow Offline')
                                        <span style="font-size: 12px; color: #E79119; font-weight: bold;">
                                            Sisa Kuota: {{ $t->stok }}
                                        </span>
                                    @else
                                        <span style="font-size: 12px; color: #4CAF50; font-weight: bold;">
                                            Unlimited
                                        </span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="submit-section">
                    <button type="submit" class="submit-button">
                        Daftar Sekarang (Gratis)
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bundle-card');
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    // Reset semua kartu
                    cards.forEach(c => c.classList.remove('active'));
                    // Set kartu ini jadi aktif
                    this.classList.add('active');
                    // Centang radio button di dalamnya
                    this.querySelector('input').checked = true;
                });
            });
        });
    </script>
</body>
</html>