<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway To PTN</title>
    <!-- New Landing Page CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing-new.css') }}">
    
    <!-- Fonts -->
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
            <img src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="GTP Logo">
            <span>Gateway to PTN</span>
        </a>
        <ul class="navbar-content">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="#speakers">Speakers</a></li>
            @auth
                <li><a href="{{ route('dashboard') }}">Ticket</a></li>
            @else
                <li><a href="#" class="restricted-link">Ticket</a></li>
            @endauth
        </ul>
        
        @auth
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
        @else
        <div class="login-signup">
            <button type="button" onclick="window.location.href='{{ route('login') }}'">Login</button>
            <button type="button" onclick="window.location.href='{{ route('register') }}'">Signup</button>
        </div>
        @endauth
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content reveal active">
            <h1 class="hero-title">Gateway to<br>Perguruan Tinggi Negeri</h1>
            <p class="hero-description">
                Platform persiapan terbaikmu menuju kampus impian. Gabungkan sosialisasi, talkshow inspiratif, dan tryout UTBK/SNBT untuk meraih kursi di PTN favoritmu.
            </p>
            <div class="login-signup" style="justify-content: flex-start;">
                @auth
                    <button style="background: var(--color-pink); color: var(--color-navy-deep); border: none;" onclick="window.location.href='{{ route('dashboard') }}'">Lihat Tiket Saya</button>
                @else
                    <button style="background: var(--color-pink); color: var(--color-navy-deep); border: none;" onclick="window.location.href='{{ route('register') }}'">Daftar Sekarang</button>
                @endauth
            </div>
        </div>
        <div class="hero-image-container reveal active">
            <!-- Using displayCard.jpg as placeholder hero image -->
            <img src="{{ asset('assets/images/displayCard.jpg') }}" alt="Hero Image">
        </div>
    </section>

    <!-- Partnership Section -->
    <div class="partnership-section">
        <div class="partnership-track">
            <!-- Placeholder Logos -->
            <span class="partner-logo">RUANGTAMU</span>
            <span class="partner-logo">PEPSODAMN</span>
            <span class="partner-logo">UNIVELER</span>
            <span class="partner-logo">INDOMIEMART</span>
            <span class="partner-logo">AQU4?</span>
            <span class="partner-logo">GANERA</span>
            <!-- Duplicate for seamless loop -->
            <span class="partner-logo">RUANGTAMU</span>
            <span class="partner-logo">PEPSODAMN</span>
            <span class="partner-logo">UNIVELER</span>
            <span class="partner-logo">INDOMIEMART</span>
            <span class="partner-logo">AQU4?</span>
            <span class="partner-logo">GANERA</span>
        </div>
    </div>

    <!-- Theme Section -->
    <section class="theme-section">
        <div class="theme-container reveal">
            <div class="theme-text" style="text-align: center; margin: 0 auto; max-width: 900px;">
                <h2 class="section-title" style="text-align: center;">Our Theme:<br><span>"Beyond Limits: Tembus Batas Impianmu"</span></h2>
                <p style="text-align: center;">
                    Perjalanan menuju PTN impian bukan hanya soal seberapa banyak soal yang kamu kerjakan, tapi seberapa kuat tekadmu untuk melampaui batasan diri.
                </p>
                <p style="text-align: center;">
                    Di Gateway to PTN 2025, kami mengajakmu untuk tidak hanya bermimpi, tapi membangun strategi nyata. Temukan potensimu, kalahkan rasa takutmu, dan buktikan bahwa kursi di kampus impian itu layak menjadi milikmu.
                </p>
                <ul class="theme-points" style="justify-content: center;">
                    <li>Strategi Tepat Sasaran</li>
                    <li>Mindset Juara</li>
                    <li>Komunitas Suportif</li>
                    <li>Mentoring Eksklusif</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section id="testimonials" class="testimonial-section">
        <h2 class="section-title reveal">Apa Kata Mereka?</h2>
        <div class="testimonial-track">
            <!-- Testimonial 1 -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Acara ini benar-benar membuka wawasan saya tentang strategi masuk PTN. Materi yang dibawakan sangat daging dan mudah dipraktekkan!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 1" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Rizky Ramadhan</h4>
                        <p class="user-role">Institut Teknologi Bandung - Teknik Informatika'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Berkat tryout dan sesi konsultasi di sini, saya jadi lebih percaya diri menghadapi UTBK. Sangat recommended buat pejuang PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 2" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Sarah Amalia</h4>
                        <p class="user-role">Universitas Indonesia - Ilmu Komunikasi'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Speaker-nya keren-keren banget! Banyak tips rahasia yang gak bakal didapetin di tempat lain. Terima kasih Gateway to PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 3" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Dimas Anggara</h4>
                        <p class="user-role">Universitas Gadjah Mada - Manajemen'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Simulasi UTBK-nya sangat mirip dengan aslinya. Pembahasannya juga detail banget, jadi paham konsep bukan cuma hafal rumus."</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 4" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Putri Lestari</h4>
                        <p class="user-role">Institut Teknologi Sepuluh Nopember - Teknik Industri'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 5 -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Komunitasnya suportif banget. Bisa sharing sama temen-temen seperjuangan dari seluruh Indonesia. Semangat pejuang PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 5" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Ahmad Fauzi</h4>
                        <p class="user-role">Universitas Padjadjaran - Hukum'24</p>
                    </div>
                </div>
            </div>

            <!-- DUPLICATE FOR INFINITE SCROLL -->
            
            <!-- Testimonial 1 Copy -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Acara ini benar-benar membuka wawasan saya tentang strategi masuk PTN. Materi yang dibawakan sangat daging dan mudah dipraktekkan!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 1" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Rizky Ramadhan</h4>
                        <p class="user-role">Institut Teknologi Bandung - Teknik Informatika'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 Copy -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Berkat tryout dan sesi konsultasi di sini, saya jadi lebih percaya diri menghadapi UTBK. Sangat recommended buat pejuang PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 2" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Sarah Amalia</h4>
                        <p class="user-role">Universitas Indonesia - Ilmu Komunikasi'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 Copy -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Speaker-nya keren-keren banget! Banyak tips rahasia yang gak bakal didapetin di tempat lain. Terima kasih Gateway to PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 3" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Dimas Anggara</h4>
                        <p class="user-role">Universitas Gadjah Mada - Manajemen'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 Copy -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Simulasi UTBK-nya sangat mirip dengan aslinya. Pembahasannya juga detail banget, jadi paham konsep bukan cuma hafal rumus."</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 4" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Putri Lestari</h4>
                        <p class="user-role">Institut Teknologi Sepuluh Nopember - Teknik Industri'24</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 5 Copy -->
            <div class="testimonial-card">
                <div class="quote-icon">❝</div>
                <p class="testimonial-text">"Komunitasnya suportif banget. Bisa sharing sama temen-temen seperjuangan dari seluruh Indonesia. Semangat pejuang PTN!"</p>
                <div class="testimonial-user">
                    <img src="{{ asset('assets/images/profilePic.png') }}" alt="User 5" class="user-image">
                    <div class="user-info">
                        <h4 class="user-name">Ahmad Fauzi</h4>
                        <p class="user-role">Universitas Padjadjaran - Hukum'24</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Speaker Section -->
    <section id="speakers" class="speaker-section">
        <h2 class="section-title reveal">Meet Our Speakers</h2>
        <div class="speaker-container">
            <!-- Speaker 1 -->
            <div class="speaker-card reveal">
                <img src="{{ asset('assets/images/speaker.png') }}" alt="Speaker 1" class="speaker-image">
                <h3 class="speaker-name">Dr. Budi Santoso</h3>
                <p class="speaker-role">Dosen UI</p>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #ccc;">Ahli dalam strategi tembus PTN favorit dengan pengalaman 10 tahun.</p>
            </div>
            
            <!-- Speaker 2 -->
            <div class="speaker-card reveal">
                <img src="{{ asset('assets/images/speaker.png') }}" alt="Speaker 2" class="speaker-image">
                <h3 class="speaker-name">Siti Aminah</h3>
                <p class="speaker-role">Motivator Pendidikan</p>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #ccc;">Membantu siswa menemukan potensi diri dan jurusan yang tepat.</p>
            </div>

            <!-- Speaker 3 -->
            <div class="speaker-card reveal">
                <img src="{{ asset('assets/images/speaker.png') }}" alt="Speaker 3" class="speaker-image">
                <h3 class="speaker-name">Andi Pratama</h3>
                <p class="speaker-role">Alumni ITB</p>
                <p style="margin-top: 10px; font-size: 0.9rem; color: #ccc;">Sharing pengalaman sukses lolos SBMPTN dengan nilai tinggi.</p>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    <section id="events" class="timeline-section" style="text-align: center;">
        <h2 class="section-title reveal">Event Timeline</h2>
        <div class="timeline-container" style="text-align: left;">
            @forelse($events as $index => $event)
                <div class="timeline-item {{ $index % 2 == 0 ? 'left' : 'right' }} reveal">
                    <div class="timeline-content">
                        <div class="timeline-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($event->tanggal_event)->locale('id')->isoFormat('D MMMM Y') }}
                        </div>
                        <h3 class="timeline-title">{{ $event->nama_event }}</h3>
                        <p>{{ Str::limit($event->deskripsi, 150) }}</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center;">No events scheduled yet.</p>
            @endforelse
        </div>
    </section>



    <!-- Footer -->
    <footer style="text-align: center; padding: 30px; background: rgba(0,0,0,0.2);">
        <p>&copy; 2025 Gateway to PTN. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        // Scroll Animation Script
        document.addEventListener('DOMContentLoaded', function() {
            const reveals = document.querySelectorAll('.reveal');

            const revealOnScroll = () => {
                const windowHeight = window.innerHeight;
                const elementVisible = 150;

                reveals.forEach((reveal) => {
                    const elementTop = reveal.getBoundingClientRect().top;
                    if (elementTop < windowHeight - elementVisible) {
                        reveal.classList.add('active');
                    }
                });
            };

            window.addEventListener('scroll', revealOnScroll);
            // Trigger once on load
            revealOnScroll();
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Dropdown Toggle Logic (Only if element exists)
            const profileTrigger = document.getElementById('profileTrigger');
            const dropdownMenu = document.getElementById('dropdownMenu');

            if (profileTrigger && dropdownMenu) {
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
            }
        });
    </script>
</body>
</html>
