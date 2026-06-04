<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Elevate</title>
    
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
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg text-white text-2xl">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Kata Sandi Baru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                    Silakan masukkan kata sandi baru Anda. Pastikan kata sandi kuat dan mudah diingat.
                </p>
            </div>

            <form action="/reset-password/process" method="post" class="space-y-5">
                
                <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">
                <input type="hidden" name="email" value="<?= esc($email ?? '') ?>">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Kata Sandi Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="new_password" name="new_password" required minlength="8"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                               placeholder="Minimal 8 karakter">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600" onclick="togglePassword('new_password', 'eye-icon-1')">
                            <i class="fa-solid fa-eye" id="eye-icon-1"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Konfirmasi Sandi Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-shield-halved text-gray-400"></i>
                        </div>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm"
                               placeholder="Ulangi kata sandi baru">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600" onclick="togglePassword('confirm_password', 'eye-icon-2')">
                            <i class="fa-solid fa-eye" id="eye-icon-2"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3.5 rounded-xl font-bold tracking-wide hover:from-blue-700 hover:to-purple-700 transition shadow-lg hover:shadow-blue-500/30 transform active:scale-[0.98] flex justify-center items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Kata Sandi
                    </button>
                </div>
            </form>
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