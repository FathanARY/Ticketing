<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gateway To PTN</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard-new.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="Logo">
            <span>Gateway To PTN</span>
        </a>

<<<<<<< HEAD
        <div class="profile-section">
            <div class="profile-trigger" id="profileTrigger">
                <div class="profile-avatar">
                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
=======
    <div class="main">
            <div class="profile font-3">
                <div class="cover">
                    <div class="judul">
                        <h1>BELI TIKET</br><span style="color : #cc3300;">SEKARANG !</span><h1>
                    </div>
                    <div class="univ">
                        <div class="by-box">*</div>
                        <div class="ie-box">SLOT TERBATAS</div>
                    </div>
                </div>
                <div class="description font-1">
                    <p>Dapatkan tiket Anda sekarang dan bergabunglah dengan kami dalam acara yang tak terlupakan ini. Jangan lewatkan kesempatan untuk belajar, networking, dan bersenang-senang bersama para calon mahasiswa lainnya!
                    </p>
                </div>
                <div class="description font-1">
                    <a href="{{ route('ticket.dashboard') }}">
                        <button type="button" style="margin:10px 0px;">Beli Tiket</button>
                    </a>
>>>>>>> fe8adb1 (forgot password)
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
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
                
                <div class="dropdown-divider"></div>
                
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #ff6b6b;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

<<<<<<< HEAD
    <!-- Main Content -->
    <div class="dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Welcome back, {{ explode(' ', Auth::user()->nama_lengkap)[0] }}!</h1>
                <p>Ready to prepare for your dream university?</p>
=======
    <div class="tickets-section font-1 page-2">
        <div class="tickets-container">
            <div class="tickets-header">
                <h1 class="font-3">Tiket Saya</h1>
                <p>Lihat status pembelian tiket Anda</p>
>>>>>>> fe8adb1 (forgot password)
            </div>
            <div class="welcome-action">
                <a href="{{ route('ticket.dashboard') }}" class="btn-primary">
                    <i class="fas fa-ticket-alt"></i> Buy New Ticket
                </a>
            </div>
        </div>

        <!-- My Tickets Section -->
        <div class="section-title">
            <i class="fas fa-ticket-alt" style="color: var(--color-pink);"></i> My Tickets
        </div>

        <div class="tickets-grid">
            @if($tickets->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-ticket-alt" style="font-size: 4rem; color: rgba(255,255,255,0.2); margin-bottom: 20px;"></i>
                    <h3>No Tickets Yet</h3>
                    <p>You haven't purchased any tickets yet. Join our events now!</p>
                    <a href="{{ route('ticket.dashboard') }}" class="btn-primary">Browse Events</a>
                </div>
            @else
                @foreach($tickets as $ticket)
                <div class="ticket-card">
                    <div class="ticket-status status-{{ $ticket->status }}">
                        {{ ucfirst($ticket->status) }}
                    </div>
                    <div class="ticket-image">
                        <!-- Placeholder image or event image if available -->
                        <img src="{{ asset('assets/images/displayCard.jpg') }}" alt="Event Image">
                    </div>
                    <div class="ticket-content">
                        <h3>{{ $ticket->event_name ?? 'Gateway To PTN Event' }}</h3>
                        
                        <div class="ticket-info">
                            <div class="info-row">
                                <i class="fas fa-hashtag" style="width: 20px;"></i>
                                <span>Order ID: #{{ $ticket->order_id }}</span>
                            </div>
                            <div class="info-row">
                                <i class="far fa-calendar-alt" style="width: 20px;"></i>
                                <span>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d M Y') }}</span>
                            </div>
                            @if($ticket->bundle_type)
                            <div class="info-row">
                                <i class="fas fa-tag" style="width: 20px;"></i>
                                <span>{{ $ticket->bundle_type }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="ticket-footer">
                            <div class="ticket-price">
                                Rp {{ number_format($ticket->amount ?? $ticket->price ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

<<<<<<< HEAD
=======
    <div id="proofModal" class="proof-modal">
        <div class="proof-modal-backdrop" onclick="closeProofModal()"></div>
        <div class="proof-modal-content">
            <button class="proof-modal-close" onclick="closeProofModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M6 6L18 18M6 18L18 6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="proof-modal-image">
                <img id="proofImage" src="" alt="Bukti Pembayaran">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/scripts.js') }}"></script>
>>>>>>> fe8adb1 (forgot password)
    <script>
        // Dropdown Toggle Logic
        const profileTrigger = document.getElementById('profileTrigger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
