<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Elevate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070')] bg-cover bg-center bg-no-repeat bg-fixed min-h-screen">

    <div class="min-h-screen flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white/95 dark:bg-gray-900/95 shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row max-w-4xl w-full transition-all duration-300 transform hover:scale-[1.01] border border-white/20 dark:border-gray-700/50">
            
            <div class="hidden md:flex flex-col justify-center items-center text-white p-12 bg-gradient-to-br from-blue-600/90 via-indigo-600/90 to-purple-700/90 md:w-1/2 relative overflow-hidden backdrop-blur-md">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-400/20 rounded-full blur-xl"></div>
                
                <div class="relative z-10 text-center flex flex-col items-center">
                    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo Elevate" class="w-28 h-28 mb-3 object-contain drop-shadow-2xl" onerror="this.outerHTML='<div class=\'bg-white/20 p-4 rounded-full mb-4 shadow-lg backdrop-blur-sm border border-white/30\'><i class=\'fa-solid fa-calendar-check text-5xl text-white\'></i></div>'">
                    
                    <h1 class="text-4xl font-extrabold mb-4 tracking-tight drop-shadow-md">
                        Elevate
                    </h1>
                    <div class="w-16 h-1 bg-white rounded-full mb-6 opacity-75"></div>
                    <p class="text-base text-blue-50 leading-relaxed max-w-sm">
                        Platform modern untuk memesan tiket dan mengelola acara favoritmu dengan mudah dan cepat.
                    </p>
                </div>
            </div>

            <div class="p-8 md:p-12 w-full md:w-1/2 flex flex-col justify-center dark:text-gray-100 bg-white dark:bg-gray-900">
                <div class="mb-6 text-center md:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-800 dark:text-white">
                        Selamat Datang
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Masuk untuk mengelola dan menjelajahi berbagai acara.</p>
                </div>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-3 rounded-r-lg mb-4 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <?= esc(session()->getFlashdata('error')); ?>
                    </div>
                <?php endif; ?>

                <form action="/login/process" method="post" class="space-y-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" name="email" value="<?= old('email'); ?>"
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                                   placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Kata Sandi
                            </label>
                            <a href="/forgot-password" class="text-xs font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 transition">
                                Lupa kata sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password"
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                                   placeholder="••••••••" required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600" onclick="togglePassword('password', 'eye-icon')">
                                <i class="fa-solid fa-eye" id="eye-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3.5 rounded-xl font-bold tracking-wide hover:from-blue-700 hover:to-purple-700 transition shadow-lg hover:shadow-blue-500/30 transform active:scale-[0.98] flex justify-center items-center gap-2">
                            <span>Masuk ke Sistem</span>
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Belum punya akun? 
                        <a href="/register" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-5 font-medium">
                        &copy; <?= date('Y'); ?> Elevate Management System
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>