document.addEventListener('DOMContentLoaded', function () {

    const hiddenImg = document.getElementById("speaker-hidden");
    const realImg = document.getElementById("speaker-real");

    if (hiddenImg && realImg) {
        hiddenImg.addEventListener("click", () => {
            hiddenImg.classList.add("fade-out");
            setTimeout(() => {
                hiddenImg.classList.add("hidden");
                realImg.classList.remove("hidden");
                realImg.classList.add("fade-in");
            }, 600);
        });
    }

    const isLoggedIn = window.GatewayToPTN?.isLoggedIn || false;
    const loginUrl = window.GatewayToPTN?.loginUrl || '/login';

    const restrictedLinks = document.querySelectorAll('.restricted-link');
    restrictedLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            if (!isLoggedIn) {
                e.preventDefault();
                alert('Harap login terlebih dahulu.');
                window.location.href = loginUrl;
            }
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const offsetTop = targetElement.offsetTop;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Fungsi Buka Modal
function openBioModal() {
    document.getElementById("bioModal").style.display = "block";
    document.body.style.overflow = "hidden"; // Matikan scroll background
}

// Fungsi Tutup Modal
function closeBioModal() {
    document.getElementById("bioModal").style.display = "none";
    document.body.style.overflow = "auto"; // Nyalakan scroll lagi
}

// Tutup modal jika user klik di luar kotak putih
window.onclick = function(event) {
    const modal = document.getElementById("bioModal");
    if (event.target == modal) {
        closeBioModal();
    }
}