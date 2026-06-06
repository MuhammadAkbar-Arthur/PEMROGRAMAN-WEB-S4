<?php
$isLoggedIn = session()->get('logged_in');
$role = session()->get('role');
?>
<footer class="bg-white dark:bg-gray-950 text-gray-600 dark:text-gray-300 mt-auto border-t border-gray-200 dark:border-gray-800">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            <div>
                <a href="/" class="flex items-center gap-2 mb-4">
                    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo Elevate" class="w-8 h-8 object-contain">
                    <span class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight">
                        Elevate
                    </span>
                </a>
                <p class="text-sm leading-relaxed mb-6 text-gray-500 dark:text-gray-400">
                    Platform ekosistem booking event modern untuk seminar, konser, workshop, dan berbagai acara akademik maupun hiburan.
                </p>
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/arthur.bar__/" target="_blank" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-blue-600 hover:text-white transition">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/muhammad-akbar-8367a3280/" target="_blank" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-blue-600 hover:text-white transition">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://github.com/MuhammadAkbar-Arthur" target="_blank" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-blue-600 hover:text-white transition">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Navigasi Cepat</h2>
                <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                    
                    <?php if(!$isLoggedIn): ?>
                        <li><a href="/" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="/login" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Masuk</a></li>
                        <li><a href="/register" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Daftar Akun</a></li>
                    
                    <?php elseif($role == 'user'): ?>
                        <li><a href="/" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="/favorite" class="hover:text-pink-600 dark:hover:text-pink-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Wishlist</a></li>
                        <li><a href="/my-bookings" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Tiket Saya</a></li>
                        <li><a href="/profile" class="hover:text-amber-600 dark:hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Profil</a></li>
                    
                    <?php elseif($role == 'organizer'): ?>
                        <li><a href="/organizer" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Dashboard Organizer</a></li>
                        <li><a href="/organizer/my-events" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Acara Saya</a></li>
                        <li><a href="/event/create" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Buat Acara</a></li>
                        <li><a href="/organizer/bookings" class="hover:text-purple-600 dark:hover:text-purple-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Kelola Pesanan</a></li>
                        <li><a href="/profile" class="hover:text-amber-600 dark:hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Profil</a></li>
                    
                    <?php elseif($role == 'admin'): ?>
                        <li><a href="/admin" class="hover:text-amber-600 dark:hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Dashboard Admin</a></li>
                        <li><a href="/event" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Kelola Acara</a></li>
                        <li><a href="/admin/users" class="hover:text-blue-600 dark:hover:text-blue-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Kelola Pengguna</a></li>
                        <li><a href="/admin/categories" class="hover:text-purple-600 dark:hover:text-purple-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px]"></i> Kelola Kategori</a></li>
                    <?php endif; ?>

                </ul>
            </div>

            <!-- Kolom 3: Info Kontak -->
            <div>
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Hubungi Kami</h2>
                <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                    <li class="flex items-start gap-4">
                        <div class="mt-1 w-6 text-center text-blue-500"><i class="fa-solid fa-location-dot text-lg"></i></div>
                        <span>Mataram, Nusa Tenggara Barat<br>Indonesia</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="w-6 text-center text-blue-500"><i class="fa-solid fa-envelope text-lg"></i></div>
                        <!-- Tampilan profesional, tujuan email aslimu -->
                        <a href="mailto:plamlagi123@gmail.com" class="hover:text-blue-600 dark:hover:text-blue-400 transition font-medium">support@elevate.com</a>
                    </li>
                    <li class="flex items-center gap-4">
                        <div class="w-6 text-center text-blue-500"><i class="fa-brands fa-whatsapp text-lg"></i></div>
                        <!-- Klik langsung chat WA -->
                        <a href="https://wa.me/6285253820284" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition font-medium">+62 852 5382 0284</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-200 dark:border-gray-800 mt-12 pt-6 text-center text-xs font-medium text-gray-400 dark:text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>&copy; <?= date('Y') ?> Elevate Management System. All rights reserved.</p>
            <p>Developed for Final Project (Web Programming & APBO) &bull; Teknik Informatika, Universitas Mataram</p>
        </div>
    </div>
</footer>

<script>
<?php if(session()->getFlashdata('success')): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: <?= json_encode(session()->getFlashdata('success')); ?>,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    });
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: <?= json_encode(session()->getFlashdata('error')); ?>,
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    });
<?php endif; ?>
</script>