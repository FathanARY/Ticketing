<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gateway to PTN - Ticket Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/landing-new.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ticket-dashboard-new.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
            src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="Logo">
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

    <div class="ticket-dashboard-container">
        <div class="content-wrapper">
            <form id="ticketForm">
                @csrf
                <!-- Step 1: User Details -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="step-number">1</div>
                        <h2 class="section-title">Detail Pemesan</h2>
                    </div>
                    <div class="section-content">
                        <div class="input-group">
                            <label class="input-label">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                class="input-field" 
                                placeholder="Masukkan email aktif"
                                value="{{ Auth::user()->email }}"
                                required
                            >
                        </div>
                        <div class="input-group">
                            <label class="input-label">Phone Number</label>
                            <input 
                                type="tel" 
                                name="phone" 
                                id="phone"
                                class="input-field" 
                                placeholder="Masukkan nomor WhatsApp"
                                value="{{ Auth::user()->no_hp }}"
                                required
                            >
                        </div>
                        <p class="input-note">* E-Ticket akan dikirimkan ke email yang terdaftar.</p>
                    </div>
                </div>

                <!-- Step 2: Choose Bundle -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="step-number">2</div>
                        <h2 class="section-title">Pilih Tiket</h2>
                    </div>
                    <div class="section-content">
                        <div class="bundle-grid">
                            @foreach($ticketBundles as $bundle)
                            <label class="bundle-card">
                               <input 
                                 type="radio" 
                                 name="bundle" 
                                 value="{{ $bundle['type'] }}" 
                                 class="bundle-radio"
                                 data-price="{{ $bundle['price'] }}"
                                 data-name="{{ $bundle['name'] }}"
                                 required
                               >
                                <div class="bundle-content">
                                    <div class="bundle-icon">
                                        <i class="fas fa-ticket-alt" style="font-size: 2rem; color: var(--color-pink);"></i>
                                    </div>
                                    <span class="bundle-name">{{ $bundle['name'] }}</span>
                                    <span class="bundle-price">
                                        {{ $bundle['price'] == 0 ? 'FREE' : 'Rp ' . number_format($bundle['price'], 0, ',', '.') }}
                                    </span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment Method (Hidden for free tickets) -->
                <div class="section-card" id="paymentSection">
                    <div class="section-header">
                        <div class="step-number">3</div>
                        <h2 class="section-title">Metode Pembayaran</h2>
                    </div>
                    <div class="section-content">
                        <div class="payment-grid">
                            <label class="payment-card">
                                <input 
                                    type="radio" 
                                    name="payment" 
                                    value="online" 
                                    class="payment-radio"
                                >
                                <div class="payment-content">
                                    <i class="fas fa-credit-card" style="font-size: 1.5rem; color: var(--color-purple-vibrant);"></i>
                                    <div>
                                        <p class="payment-name" style="font-weight: 600; margin-bottom: 2px;">Pembayaran Online</p>
                                        <p class="payment-desc" style="font-size: 0.8rem; color: var(--text-muted);">QRIS, E-Wallet, Virtual Account</p>
                                    </div>
                                </div>
                            </label>
                            <label class="payment-card">
                                <input 
                                    type="radio" 
                                    name="payment" 
                                    value="cash" 
                                    class="payment-radio"
                                >
                                <div class="payment-content">
                                    <i class="fas fa-money-bill-wave" style="font-size: 1.5rem; color: var(--color-purple-vibrant);"></i>
                                    <div>
                                        <p class="payment-name" style="font-weight: 600; margin-bottom: 2px;">Transfer Manual / Cash</p>
                                        <p class="payment-desc" style="font-size: 0.8rem; color: var(--text-muted);">Upload bukti transfer</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Free Ticket Notice (Shown when free ticket selected) -->
                <div class="section-card" id="freeTicketNotice" style="display: none;">
                    <div class="section-header">
                        <div class="step-number" style="background: #4CAF50;"><i class="fas fa-check"></i></div>
                        <h2 class="section-title">Tiket Gratis!</h2>
                    </div>
                    <div class="section-content">
                        <div style="text-align: center; padding: 20px;">
                            <i class="fas fa-gift" style="font-size: 3rem; color: #4CAF50; margin-bottom: 15px;"></i>
                            <p style="color: var(--text-muted); margin-bottom: 10px;">Tiket ini <strong>GRATIS</strong>! Anda tidak perlu melakukan pembayaran.</p>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Klik tombol <strong>"Klaim Tiket Gratis"</strong> untuk mendapatkan tiket Anda.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="order-summary">
            <h3 class="summary-title">Ringkasan Pesanan</h3>
            <div class="summary-row">
                <span>Tiket</span>
                <span id="summaryTicketName">-</span>
            </div>
            <div class="summary-row">
                <span>Harga</span>
                <span id="summaryTicketPrice">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Biaya Admin</span>
                <span>Rp 0</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span id="summaryTotal">Rp 0</span>
            </div>
            <button type="button" class="btn-checkout" id="payButton" onclick="submitForm()">
                Bayar Sekarang
            </button>
        </div>
    </div>

    <script>
        // Dropdown Toggle Logic
        const profileTrigger = document.getElementById('profileTrigger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!profileTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        });

        // Update Summary Logic + Toggle Payment Section for Free Tickets
        const bundleRadios = document.querySelectorAll('input[name="bundle"]');
        const summaryTicketName = document.getElementById('summaryTicketName');
        const summaryTicketPrice = document.getElementById('summaryTicketPrice');
        const summaryTotal = document.getElementById('summaryTotal');
        const paymentSection = document.getElementById('paymentSection');
        const freeTicketNotice = document.getElementById('freeTicketNotice');
        const payButton = document.getElementById('payButton');
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        
        let isTicketFree = false;

        bundleRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const name = this.getAttribute('data-name');
                const price = parseInt(this.getAttribute('data-price'));
                
                summaryTicketName.textContent = name;
                summaryTicketPrice.textContent = price === 0 ? 'GRATIS' : 'Rp ' + price.toLocaleString('id-ID');
                summaryTotal.textContent = price === 0 ? 'GRATIS' : 'Rp ' + price.toLocaleString('id-ID');
                
                // Toggle payment section based on price
                if (price === 0) {
                    isTicketFree = true;
                    paymentSection.style.display = 'none';
                    freeTicketNotice.style.display = 'block';
                    payButton.textContent = 'Klaim Tiket Gratis';
                    payButton.style.background = 'linear-gradient(135deg, #4CAF50, #8BC34A)';
                    // Uncheck payment methods
                    paymentRadios.forEach(pr => pr.checked = false);
                } else {
                    isTicketFree = false;
                    paymentSection.style.display = 'block';
                    freeTicketNotice.style.display = 'none';
                    payButton.textContent = 'Bayar Sekarang';
                    payButton.style.background = '';
                }
            });
        });

        // Form Submission Logic
        function submitForm() {
            const form = document.getElementById('ticketForm');
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const bundle = document.querySelector('input[name="bundle"]:checked');
            const payment = document.querySelector('input[name="payment"]:checked');
            
            // Basic validation
            if (!email || !phone) {
                alert('Mohon lengkapi email dan nomor telepon.');
                return;
            }
            
            if (!bundle) {
                alert('Mohon pilih tiket terlebih dahulu.');
                return;
            }
            
            // Payment validation only for paid tickets
            if (!isTicketFree && !payment) {
                alert('Mohon pilih metode pembayaran.');
                return;
            }

            const payButtonEl = document.getElementById('payButton');
            const originalText = payButtonEl.textContent;
            const originalBg = payButtonEl.style.background;
            payButtonEl.disabled = true;
            payButtonEl.textContent = 'Memproses...';
            
            const formData = new FormData(form);
            const paymentMethod = formData.get('payment');
            
            // Handle Cash Payment
            if (paymentMethod === 'cash' && !isTicketFree) {
                const orderData = {
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    bundle: formData.get('bundle')
                };
                
                const newForm = document.createElement('form');
                newForm.method = 'POST';
                newForm.action = '{{ route("ticket.cash.prepare") }}';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                newForm.appendChild(csrfInput);
                
                for (const [key, value] of Object.entries(orderData)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    newForm.appendChild(input);
                }
                
                document.body.appendChild(newForm);
                newForm.submit();
                return;
            }
            
            // Handle Online Payment OR Free Ticket
            fetch('{{ route("ticket.order") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle Free Ticket Success
                if (data.is_free || data.status === 'free_success') {
                    alert(data.message || 'Tiket berhasil diklaim!');
                    window.location.href = '{{ route("dashboard") }}';
                    return;
                }
                
                // Handle Paid Ticket with Midtrans Snap
                if (data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil!');
                            window.location.href = '{{ route("dashboard") }}';
                        },
                        onPending: function(result) {
                            alert('Pembayaran pending. Silakan selesaikan pembayaran.');
                            window.location.href = '{{ route("dashboard") }}';
                        },
                        onError: function(result) {
                            alert('Terjadi kesalahan dalam pembayaran. Silakan coba lagi.');
                            payButtonEl.disabled = false;
                            payButtonEl.textContent = originalText;
                            payButtonEl.style.background = originalBg;
                        },
                        onClose: function() {
                            payButtonEl.disabled = false;
                            payButtonEl.textContent = originalText;
                            payButtonEl.style.background = originalBg;
                        }
                    });
                } else if (data.error) {
                    alert(data.error);
                    payButtonEl.disabled = false;
                    payButtonEl.textContent = originalText;
                    payButtonEl.style.background = originalBg;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                payButtonEl.disabled = false;
                payButtonEl.textContent = originalText;
                payButtonEl.style.background = originalBg;
            });
        }
    </script>
</body>
</html>
