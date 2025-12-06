<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pending - Gateway to PTN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ticket-dashboard-new.css') }}">
    <style>
        .pending-container {
            max-width: 600px;
            margin: 120px auto 50px;
            padding: 0 20px;
        }

        .pending-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .pending-icon-wrapper {
            width: 80px;
            height: 80px;
            background: #fff3cd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .pending-icon-wrapper i {
            font-size: 35px;
            color: #ffc107;
        }

        .pending-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .pending-message {
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-dashboard {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
        }

        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
        }

        .btn-whatsapp:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fa-hourglass-half {
            animation: spin 3s infinite linear;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <img style ="width: 40px; height: 40px;" src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="Logo">
            <span>Gateway To PTN</span>
        </a>

        <div class="profile-section">
            <div class="profile-trigger" id="profileTrigger">
                <div class="profile-avatar">
                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                </div>
                <span class="profile-name">{{ Auth::user()->nama_lengkap }}</span>
                <i class="fas fa-chevron-down" style="font-size: 0.8rem; margin-left: 5px;"></i>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <div class="dropdown-header">
                    <span>Signed in as</span>
                    <strong>{{ Auth::user()->email }}</strong>
                </div>
                
                <div class="dropdown-divider"></div>
                
                <a href="{{ route('home.user') }}" class="dropdown-item">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('dashboard') }}" class="dropdown-item">
                    <i class="fas fa-ticket-alt"></i> Dashboard
                </a>
                
                <div class="dropdown-divider"></div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #ff6b6b;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-icon-wrapper">
                <i class="fas fa-hourglass-half"></i>
            </div>
            
            <h1 class="pending-title">Menunggu Konfirmasi Pembayaran</h1>
            
            <p class="pending-message">
                Terima kasih telah mengirimkan bukti pembayaran! <br>
                Admin kami akan segera memverifikasi pembayaran Anda. <br>
                Tiket akan muncul di Dashboard setelah pembayaran dikonfirmasi.
            </p>

            <div class="action-buttons">
                <a href="{{ route('dashboard') }}" class="btn-action btn-dashboard">
                    <i class="fas fa-columns"></i> Ke Dashboard
                </a>
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20sudah%20upload%20bukti%20pembayaran%20tiket%20Gateway%20to%20PTN" target="_blank" class="btn-action btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> Konfirmasi via WA
                </a>
            </div>
        </div>
    </div>

    <script>
        // Dropdown functionality
        const profileTrigger = document.getElementById('profileTrigger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!dropdownMenu.contains(e.target) && !profileTrigger.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
