<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Elevate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-[url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070')] bg-cover bg-center bg-no-repeat bg-fixed min-h-screen">

    <div class="min-h-screen flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 py-8 sm:py-10">
        
        <div class="bg-white/95 dark:bg-gray-900/95 shadow-2xl rounded-2xl overflow-hidden flex flex-col lg:flex-row max-w-5xl w-full transition-all duration-300 border border-white/20 dark:border-gray-700/50">
            
            <div class="hidden lg:flex flex-col justify-center items-center text-white p-12 bg-gradient-to-br from-blue-600/90 via-indigo-600/90 to-purple-700/90 lg:w-5/12 relative overflow-hidden backdrop-blur-md">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-400/20 rounded-full blur-xl"></div>
                
                <div class="relative z-10 text-center flex flex-col items-center">
                    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo Elevate" class="w-28 h-28 mb-3 object-contain drop-shadow-2xl">
                    <h1 class="text-4xl font-extrabold mb-4 tracking-tight drop-shadow-md">Elevate</h1>
                    <div class="w-16 h-1 bg-white rounded-full mb-6 opacity-75"></div>
                    <p class="text-base text-blue-50 leading-relaxed max-w-sm">
                        Platform modern untuk memesan tiket dan mengelola acara favoritmu dengan mudah dan cepat.
                    </p>
                </div>
            </div>

            <div class="p-6 sm:p-10 w-full lg:w-7/12 flex flex-col justify-center dark:text-gray-100 bg-white dark:bg-gray-900 overflow-y-auto max-h-[95vh]">
                
                <div class="mb-6 text-center lg:text-left flex flex-col lg:block items-center">
                    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo Elevate" class="w-16 h-16 mb-3 object-contain lg:hidden">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-800 dark:text-white">
                        Buat Akun Baru
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi data diri di bawah ini dengan benar.</p>
                </div>

                <?php if(session()->getFlashdata('errors')): ?>
                    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-r-lg mb-6 text-sm flex flex-col gap-2">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Terdapat kesalahan pendaftaran:
                        </div>
                        <ul class="list-disc list-inside ml-2 space-y-1">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/register/process" method="post" class="space-y-4">
                    
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Saya Mendaftar Sebagai:
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div id="role-user" class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 rounded-2xl cursor-pointer transition flex items-center sm:items-start gap-3 sm:gap-4 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 active" onclick="toggleRole('user')">
                                <div class="bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user-astronaut text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white leading-tight">Peserta Acara</h4>
                                    <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 mt-1 leading-snug">Mencari, mengikuti & pesan tiket.</p>
                                </div>
                                <input type="radio" id="user" name="role" value="user" class="hidden" checked required>
                            </div>

                            <div id="role-organizer" class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 rounded-2xl cursor-pointer transition flex items-center sm:items-start gap-3 sm:gap-4 hover:border-purple-300 dark:hover:border-purple-600 hover:bg-purple-50/50 dark:hover:bg-purple-900/20" onclick="toggleRole('organizer')">
                                <div class="bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-building-ngo text-lg sm:text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm sm:text-base text-gray-800 dark:text-white leading-tight">Penyelenggara</h4>
                                    <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 mt-1 leading-snug">Membuat & mengelola acara.</p>
                                </div>
                                <input type="radio" id="organizer" name="role" value="organizer" class="hidden">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-user text-gray-400"></i></div>
                            <input type="text" name="name" value="<?= old('name'); ?>" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-envelope text-gray-400"></i></div>
                            <input type="email" name="email" value="<?= old('email'); ?>" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 pt-1">
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300">Kata Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-lock text-gray-400"></i></div>
                                <input type="password" name="password" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-gray-700 dark:text-gray-300">Konfirmasi Sandi</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-shield-halved text-gray-400"></i></div>
                                <input type="password" name="confirm_password" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition text-gray-900 dark:text-white placeholder-gray-400 text-sm" placeholder="Ulangi kata sandi" required>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3.5 rounded-xl font-bold tracking-wide hover:from-blue-700 hover:to-purple-700 transition shadow-lg hover:shadow-indigo-500/30 transform active:scale-[0.98] flex justify-center items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>Daftar Akun Elevate</span>
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-800 pt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah punya akun? 
                        <a href="/login" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleRole(roleType) {
            const roleUserCard = document.getElementById('role-user');
            const roleOrganizerCard = document.getElementById('role-organizer');
            const roleUserRadio = document.getElementById('user');
            const roleOrganizerRadio = document.getElementById('organizer');

            roleUserCard.classList.remove('active', 'border-blue-500', 'bg-blue-50/50', 'dark:border-blue-600', 'dark:bg-blue-900/20');
            roleOrganizerCard.classList.remove('active', 'border-purple-500', 'bg-purple-50/50', 'dark:border-purple-600', 'dark:bg-purple-900/20');
            
            if (roleType === 'user') {
                roleUserRadio.checked = true;
                roleUserCard.classList.add('active', 'border-blue-500', 'bg-blue-50/50', 'dark:border-blue-600', 'dark:bg-blue-900/20');
            } else if (roleType === 'organizer') {
                roleOrganizerRadio.checked = true;
                roleOrganizerCard.classList.add('active', 'border-purple-500', 'bg-purple-50/50', 'dark:border-purple-600', 'dark:bg-purple-900/20');
            }
        }
    </script>
    
    <?php if(session()->getFlashdata('success')): ?>
    <script>
    Swal.fire({ icon: 'success', title: 'Berhasil 🎉', text: '<?= session()->getFlashdata('success'); ?>', confirmButtonColor: '#2563eb' });
    </script>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
    <script>
    Swal.fire({ icon: 'error', title: 'Oops 😢', text: '<?= esc(session()->getFlashdata('error')); ?>', confirmButtonColor: '#dc2626' });
    </script>
    <?php endif; ?>
</body>
</html>