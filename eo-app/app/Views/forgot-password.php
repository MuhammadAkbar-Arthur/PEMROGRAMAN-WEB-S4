<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Elevate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070')] bg-cover bg-center bg-no-repeat bg-fixed min-h-screen flex items-center justify-center">

    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-md p-4">
        <div class="bg-white/95 dark:bg-gray-900/95 shadow-2xl rounded-3xl overflow-hidden border border-white/20 dark:border-gray-700/50 p-8 md:p-10 transform transition-all">
            
            <div class="text-center mb-8">
                <!-- Logo Elevate Dummy -->
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-white text-2xl">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Lupa Kata Sandi?
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                    Jangan khawatir! Masukkan alamat email Anda yang terdaftar, dan kami akan membantu mengatur ulang kata sandi Anda.
                </p>
            </div>

            <form action="/forgot-password/process" method="post" class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Alamat Email Terdaftar
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                               placeholder="nama@email.com">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3.5 rounded-xl font-bold tracking-wide hover:from-blue-700 hover:to-purple-700 transition shadow-lg hover:shadow-blue-500/30 transform active:scale-[0.98] flex justify-center items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Link Reset
                </button>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
                <a href="/login" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 font-bold transition flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if(session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?= session()->getFlashdata('error'); ?>',
                confirmButtonColor: '#dc2626',
                customClass: { confirmButton: 'rounded-xl px-6' },
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
            });
        <?php endif; ?>
    </script>
</body>
</html>