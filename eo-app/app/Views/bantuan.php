<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - Elevate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

    <?= view('layout/navbar'); ?>

    <main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-8">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight">
                Halo, ada yang bisa kami bantu?
            </h1>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan umum seputar penggunaan platform Elevate, mulai dari pemesanan tiket hingga pengelolaan acara.
            </p>
        </div>

        <div class="max-w-2xl mx-auto mb-12 relative">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" id="faqSearch" placeholder="Ketik kata kunci pertanyaan Anda di sini..." 
                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 dark:text-white pl-14 pr-4 py-4 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-circle-question text-blue-500"></i> Pertanyaan yang Sering Diajukan (FAQ)
            </h2>

            <div class="faq-item border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 rounded-xl overflow-hidden transition-all duration-200">
                <button class="faq-btn w-full px-6 py-4 text-left font-semibold text-gray-800 dark:text-white flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Bagaimana cara memesan tiket acara?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-800 mt-2 pt-4">
                    Untuk memesan tiket, pastikan Anda sudah membuat akun dan masuk (login). Cari acara yang Anda inginkan di halaman Beranda, klik "Lihat Detail Acara", lalu tekan tombol "Pesan Tiket". Tiket Anda akan otomatis masuk ke menu "Tiket Saya".
                </div>
            </div>

            <div class="faq-item border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 rounded-xl overflow-hidden transition-all duration-200">
                <button class="faq-btn w-full px-6 py-4 text-left font-semibold text-gray-800 dark:text-white flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Apakah saya bisa membatalkan pesanan tiket?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-800 mt-2 pt-4">
                    Kebijakan pembatalan tiket bergantung pada masing-masing penyelenggara acara (Organizer). Silakan hubungi Organizer terkait melalui kontak yang tertera pada halaman detail acara.
                </div>
            </div>

            <div class="faq-item border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 rounded-xl overflow-hidden transition-all duration-200">
                <button class="faq-btn w-full px-6 py-4 text-left font-semibold text-gray-800 dark:text-white flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Bagaimana cara menjadi Penyelenggara (Organizer)?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-800 mt-2 pt-4">
                    Saat Anda melakukan pendaftaran akun (Register), Anda dapat memilih peran sebagai "Penyelenggara Acara". Jika Anda sudah terlanjur mendaftar sebagai Peserta dan ingin mengubah akun, silakan hubungi tim Admin kami melalui email dukungan.
                </div>
            </div>

            <div class="faq-item border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 rounded-xl overflow-hidden transition-all duration-200">
                <button class="faq-btn w-full px-6 py-4 text-left font-semibold text-gray-800 dark:text-white flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Bagaimana cara menghubungi Customer Service?
                    <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-gray-800 mt-2 pt-4">
                    Anda dapat menghubungi kami melalui email di <strong>support@elevate.com</strong> atau menggunakan nomor WhatsApp yang tertera pada bagian bawah (footer) website ini. Kami siap membantu Anda pada hari kerja.
                </div>
            </div>

        </div>
    </main>

    <?= view('layout/footer'); ?>

    <script>
        // 1. Skrip untuk interaktivitas Akordion FAQ (Buka-Tutup)
        const faqButtons = document.querySelectorAll('.faq-btn');
        
        faqButtons.forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                content.classList.toggle('hidden');
                
                if (content.classList.contains('hidden')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });

        // 2. Skrip untuk Live Search Client-Side (Pencarian Instan)
        const faqSearch = document.getElementById('faqSearch');
        const faqItems = document.querySelectorAll('.faq-item');

        faqSearch.addEventListener('keyup', function() {
            const keyword = faqSearch.value.toLowerCase();

            faqItems.forEach(item => {
                const questionText = item.querySelector('.faq-btn').textContent.toLowerCase();
                const answerText = item.querySelector('.faq-content').textContent.toLowerCase();

                // Jika kata kunci ada di teks pertanyaan atau teks jawaban
                if (questionText.includes(keyword) || answerText.includes(keyword)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>