// Ticket Dashboard JavaScript (UI Logic)

document.addEventListener('DOMContentLoaded', function() {
    const bundleCards = document.querySelectorAll('.bundle-card');
    const paymentCards = document.querySelectorAll('.payment-card');
    // Mencari elemen pembungkus section pembayaran (section ke-3)
    const paymentSection = document.querySelector('.payment-grid') ? document.querySelector('.payment-grid').closest('.section-card') : null;
    const payButton = document.getElementById('payButton');
    const paymentInputs = document.querySelectorAll('input[name="payment"]');

    // 1. Logic Pemilihan Bundle Tiket (Gratis vs Berbayar)
    bundleCards.forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.querySelector('.bundle-radio');
            radio.checked = true;
            
            // Visual Feedback (Border Ungu)
            bundleCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            // Cek Harga dari atribut data-price
            const price = parseFloat(radio.dataset.price || 0);

            if (price === 0) {
                // --- TIKET GRATIS ---
                
                // 1. Sembunyikan Section Pembayaran dengan animasi halus
                if (paymentSection) {
                    paymentSection.style.opacity = '0';
                    setTimeout(() => {
                        paymentSection.style.display = 'none';
                    }, 300);
                }

                // 2. Ubah Teks Tombol
                if (payButton) payButton.textContent = 'Klaim Tiket Gratis';

                // 3. Matikan Wajib Isi (Required) pada pembayaran agar form bisa disubmit
                paymentInputs.forEach(input => {
                    input.required = false;
                    input.checked = false; // Reset pilihan
                });
                
                // Reset visual kartu pembayaran
                paymentCards.forEach(c => c.classList.remove('active'));

            } else {
                // --- TIKET BERBAYAR ---

                // 1. Tampilkan Kembali Section Pembayaran
                if (paymentSection) {
                    paymentSection.style.display = 'block';
                    setTimeout(() => {
                        paymentSection.style.opacity = '1';
                    }, 10);
                }

                // 2. Kembalikan Teks Tombol
                if (payButton) payButton.textContent = 'Pesan Tiket';

                // 3. Nyalakan Kembali Wajib Isi (Required)
                paymentInputs.forEach(input => {
                    input.required = true;
                });
            }
        });
    });

    // 2. Logic Pemilihan Metode Pembayaran
    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.querySelector('.payment-radio');
            radio.checked = true;
            
            // Visual Feedback
            paymentCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // 3. Animasi Scroll Halus (Fade In saat scroll)
    const sections = document.querySelectorAll('.section-card');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(section);
    });

    // 4. Animasi Tombol Kontak (Pulse Effect)
    const contactButton = document.querySelector('.contact-button');
    if (contactButton) {
        setInterval(() => {
            contactButton.style.transform = 'scale(1.05)';
            setTimeout(() => {
                contactButton.style.transform = 'scale(1)';
            }, 200);
        }, 3000);
    }
});

// 5. Formatter Nomor HP Indonesia (08xx / 62xx)
const phoneInput = document.querySelector('input[name="phone"]');
if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        // Hanya angka
        let value = e.target.value.replace(/\D/g, '');
        
        // Pastikan input user tetap bersih
        e.target.value = value;
    });
}