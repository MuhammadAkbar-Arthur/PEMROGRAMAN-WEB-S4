<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Elevate</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mb-12 mt-4">

    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-user-gear text-blue-600 dark:text-blue-400"></i> Profil Saya
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Kelola informasi pribadi dan pengaturan keamanan akun Anda.
            </p>
        </div>
        <a href="/" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- KARTU PROFIL -->
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 shadow-xl border border-gray-100 dark:border-gray-800 rounded-3xl overflow-hidden relative">
        
        <!-- Aksen Latar Belakang Atas -->
        <div class="h-32 bg-gradient-to-r from-blue-600 to-purple-600 w-full absolute top-0 left-0 z-0"></div>

        <div class="relative z-10 p-6 md:p-10 pt-16 md:pt-20">
            <!-- FOTO PROFIL & ROLE -->
            <div class="flex flex-col items-center justify-center mb-10">
                <div class="relative group">
                    <?php if($user['avatar']): ?>
                        <img src="/uploads/<?= esc($user['avatar'], 'url'); ?>"
                             class="w-36 h-36 rounded-full object-cover border-4 border-white dark:border-gray-900 shadow-lg bg-white">
                    <?php else: ?>
                        <div class="w-36 h-36 rounded-full bg-gray-100 dark:bg-gray-800 border-4 border-white dark:border-gray-900 flex items-center justify-center text-6xl text-gray-300 dark:text-gray-600 shadow-lg">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Role Badge -->
                    <div class="absolute bottom-1 right-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-[10px] font-bold px-3 py-1 rounded-full border-2 border-white dark:border-gray-900 uppercase tracking-widest shadow-sm">
                        <?= esc(session()->get('role')); ?>
                    </div>
                </div>
            </div>

            <!-- FORM UPDATE -->
            <form action="/profile/update" method="post" enctype="multipart/form-data">
                
                <h3 class="text-lg font-bold mb-5 text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">
                    <i class="fa-solid fa-address-card text-blue-500 mr-2"></i> Informasi Pribadi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Input Nama -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="name" value="<?= esc($user['name']); ?>" 
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white font-medium" required>
                        </div>
                    </div>

                    <!-- Input Email (Disabled) -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" value="<?= esc($user['email']); ?>" 
                                   class="w-full border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/50 pl-11 pr-4 py-3 rounded-xl text-gray-500 dark:text-gray-500 cursor-not-allowed font-medium" disabled title="Email tidak dapat diubah">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-300 dark:text-gray-600 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Input Telepon -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-phone text-gray-400"></i>
                            </div>
                            <input type="text" name="phone" value="<?= esc($user['phone']); ?>" placeholder="08xxxxxxxxxx"
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white font-medium">
                        </div>
                    </div>

                    <!-- Input Bio -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Bio Singkat</label>
                        <div class="relative">
                            <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                <i class="fa-solid fa-quote-left text-gray-400"></i>
                            </div>
                            <textarea name="bio" rows="4" placeholder="Ceritakan sedikit tentang dirimu..."
                                      class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white font-medium"><?= esc($user['bio']); ?></textarea>
                        </div>
                    </div>

                    <!-- Input Avatar -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Ubah Foto Profil</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="mb-1 text-sm text-gray-500 dark:text-gray-400 font-semibold"><span class="text-blue-600 dark:text-blue-400">Klik untuk unggah</span> atau seret file ke sini</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, atau WEBP (Maks. 2MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="avatar" accept="image/png, image/jpeg, image/webp" class="hidden" />
                            </label>
                        </div>
                    </div>
                </div>

                <!-- KEAMANAN (UBAH SANDI) -->
                <h3 class="text-lg font-bold mb-5 mt-10 text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">
                    <i class="fa-solid fa-shield-halved text-purple-500 mr-2"></i> Keamanan Akun
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-purple-50/50 dark:bg-purple-900/10 p-6 rounded-2xl border border-purple-100 dark:border-purple-900/30">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Kata Sandi Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-key text-gray-400"></i>
                            </div>
                            <input type="password" id="new_pwd" name="password" placeholder="Kosongkan jika tidak diubah" 
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 pl-11 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition text-gray-900 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600" onclick="togglePassword('new_pwd', 'eye-icon-1')">
                                <i class="fa-solid fa-eye" id="eye-icon-1"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-check-double text-gray-400"></i>
                            </div>
                            <input type="password" id="conf_pwd" name="confirm_password" placeholder="Ulangi kata sandi baru" 
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 pl-11 pr-12 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 transition text-gray-900 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-gray-400 hover:text-gray-600" onclick="togglePassword('conf_pwd', 'eye-icon-2')">
                                <i class="fa-solid fa-eye" id="eye-icon-2"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL SIMPAN -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold px-10 py-3.5 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?= view('layout/footer'); ?>

<script>
    // Fungsi untuk Toggle Show/Hide Password
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

    // Ubah Teks File Upload setelah gambar dipilih
    document.getElementById('dropzone-file').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var labelText = this.previousElementSibling.querySelector('p span');
        labelText.textContent = "File dipilih: " + fileName;
        labelText.classList.remove('text-blue-600', 'dark:text-blue-400');
        labelText.classList.add('text-emerald-600', 'dark:text-emerald-400');
    });
</script>

<!-- SWEETALERT NOTIFICATIONS -->
<?php if(session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Disimpan!',
        text: <?= json_encode(session()->getFlashdata('success')); ?>,
        confirmButtonColor: '#2563eb',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
        customClass: { confirmButton: 'rounded-xl px-6' }
    });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Menyimpan',
        text: <?= json_encode(session()->getFlashdata('error')); ?>,
        confirmButtonColor: '#dc2626',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
        customClass: { confirmButton: 'rounded-xl px-6' }
    });
</script>
<?php endif; ?>

</body>
</html>