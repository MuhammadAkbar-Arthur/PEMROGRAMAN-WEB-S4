<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row max-w-4xl w-full transition-all duration-300 transform hover:scale-[1.01]">
        
        <div class="hidden md:flex flex-col justify-center items-center text-white p-12 bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-600 md:w-1/2 relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-400/20 rounded-full blur-xl"></div>
            
            <div class="relative z-10 text-center flex flex-col items-center">
                <h1 class="text-4xl font-extrabold mb-4 tracking-tight drop-shadow-md">
                    Event Organizer
                </h1>
                <div class="w-16 h-1 bg-white rounded-full mb-6 opacity-75"></div>
                <p class="text-base text-blue-50 leading-relaxed max-w-sm">
                    Platform modern untuk booking dan manajemen event favoritmu dengan mudah dan cepat.
                </p>
            </div>
        </div>

        <div class="p-8 md:p-12 w-full md:w-1/2 flex flex-col justify-center dark:text-gray-100">
            <div class="mb-6 text-center md:text-left">
                <h2 class="text-3xl font-bold tracking-tight text-gray-800 dark:text-white">
                    Login
                </h2>
                <p class="text-sm text-gray-400 mt-1">Masuk untuk mengelola dan menjelajahi event.</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-3 rounded-r-lg mb-4 text-sm">
                    <?= esc(session()->getFlashdata('error')); ?>
                </div>
            <?php endif; ?>

            <form action="/login/process" method="post" class="space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input type="email"
                           name="email"
                           value="<?= old('email'); ?>"
                           class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:bg-white dark:focus:bg-gray-900 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                           placeholder="nama@email.com"
                           required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input type="password"
                           name="password"
                           class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:focus:ring-purple-400 focus:bg-white dark:focus:bg-gray-900 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                           placeholder="••••••••"
                           required>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition shadow-lg hover:shadow-indigo-500/20 transform active:scale-[0.98]">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Belum punya akun? 
                    <a href="/register" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-4">
                    &copy; 2026 Event Organizer System
                </p>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session()->getFlashdata('success')): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil 🎉',
        text: '<?= session()->getFlashdata('success'); ?>',
        confirmButtonColor: '#2563eb'
    });
    </script>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Oops 😢',
        text: '<?= esc(session()->getFlashdata('error')); ?>',
        confirmButtonColor: '#dc2626'
    });
    </script>
    <?php endif; ?>

</body>
</html>