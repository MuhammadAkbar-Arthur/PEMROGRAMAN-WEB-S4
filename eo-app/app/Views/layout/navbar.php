<?php
$db = \Config\Database::connect();
$currentUrl = trim(service('uri')->getPath(), '/');
$isLoggedIn = session()->get('logged_in');
$role = session()->get('role');
$favoriteCount = 0;

if ($isLoggedIn && $role == 'user') {
    $favoriteCount = $db->table('favorites')
        ->where('user_id', session()->get('id'))
        ->countAllResults();
}
?>

<nav class="bg-white/95 dark:bg-gray-900/95 backdrop-blur-md text-gray-800 dark:text-gray-100 shadow-md transition duration-300 sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="container mx-auto px-4 md:px-6 py-3 flex justify-between items-center relative">

        <a href="/" class="flex items-center gap-2 z-50 shrink-0">
            <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo Elevate" class="w-8 h-8 object-contain">
            <span class="text-xl md:text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight">
                Elevate
            </span>
        </a>

        <div class="hidden md:flex flex-1 justify-center items-center gap-2 lg:gap-4 px-4">
            <?php if(!$isLoggedIn || $role == 'user'): ?>
                <a href="/" class="<?= $currentUrl == '' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-house text-sm"></i> Beranda
                </a>
                
                <?php if($isLoggedIn && $role == 'user'): ?>
                <a href="/favorite" class="<?= $currentUrl == 'favorite' ? 'bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-2 rounded-xl transition flex items-center gap-2 relative">
                    <i class="fa-solid fa-heart text-sm"></i> Wishlist
                    <?php if($favoriteCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm"><?= $favoriteCount; ?></span>
                    <?php endif; ?>
                </a>
                <a href="/my-bookings" class="<?= $currentUrl == 'my-bookings' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-ticket text-sm"></i> Tiket Saya
                </a>
                <?php endif; ?>

            <?php elseif($role == 'organizer'): ?>
                <a href="/organizer" class="<?= $currentUrl == 'organizer' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Dashboard</a>
                <a href="/organizer/my-events" class="<?= $currentUrl == 'organizer/my-events' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Acara Saya</a>
                <a href="/event/create" class="<?= $currentUrl == 'event/create' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Buat Acara</a>
                <a href="/organizer/bookings" class="<?= $currentUrl == 'organizer/bookings' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Kelola Pesanan</a>

            <?php elseif($role == 'admin'): ?>
                <a href="/admin" class="<?= $currentUrl == 'admin' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Dashboard</a>
                <a href="/event" class="<?= $currentUrl == 'event' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Semua Acara</a>
                <a href="/admin/users" class="<?= $currentUrl == 'admin/users' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Pengguna</a>
                <a href="/admin/categories" class="<?= $currentUrl == 'admin/categories' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800'; ?> px-4 py-2 rounded-xl transition">Kategori</a>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-2 md:gap-3 z-50 shrink-0">
            
            <button id="userDropdownBtn" onclick="toggleUserDropdown()" class="flex items-center gap-1 sm:gap-2 hover:bg-gray-100 dark:hover:bg-gray-800 p-1.5 sm:p-2 sm:pl-3 rounded-full border border-gray-200 dark:border-gray-700 transition">
                <?php if($isLoggedIn): ?>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-200 hidden lg:block mr-1">
                        <?= esc(session()->get('name')); ?>
                    </span>
                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-tr from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm text-xs sm:text-base">
                        <?= strtoupper(substr(session()->get('name'), 0, 1)); ?>
                    </div>
                <?php else: ?>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 hidden lg:block mr-1">Tamu</span>
                    <i class="fa-solid fa-circle-user text-2xl sm:text-3xl text-gray-400"></i>
                <?php endif; ?>
                <i class="fa-solid fa-chevron-down text-[10px] sm:text-xs text-gray-500 ml-1"></i>
            </button>

            <button onclick="toggleMenu()" class="md:hidden bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 p-2 rounded-lg transition">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <div id="userDropdown" class="hidden absolute top-full right-0 mt-3 w-56 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 py-2 z-50 transform origin-top-right transition-all">
                
                <?php if($isLoggedIn): ?>
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-semibold tracking-wider">Masuk sebagai</p>
                        <p class="text-sm font-bold text-gray-800 dark:text-white truncate"><?= esc(session()->get('email')); ?></p>
                    </div>
                    <?php if (session()->get('role') === 'user' || session()->get('role') === 'organizer'): ?>
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <i class="fa-solid fa-user mr-2"></i> Profil Saya
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <a href="/bantuan" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <i class="fa-solid fa-circle-question w-4 text-center"></i> Pusat Bantuan
                </a>

                <button onclick="toggleTheme()" class="w-full flex items-center justify-between px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-moon w-4 text-center" id="themeIconFA"></i> 
                        <span id="themeText">Mode Gelap</span>
                    </div>
                </button>

                <div class="border-t border-gray-100 dark:border-gray-800 mt-2 pt-2">
                    <?php if($isLoggedIn): ?>
                        <a href="/logout" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Keluar (Logout)
                        </a>
                    <?php else: ?>
                        <a href="/login" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                            <i class="fa-solid fa-arrow-right-to-bracket w-4 text-center"></i> Masuk (Login)
                        </a>
                        <a href="/register" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition">
                            <i class="fa-solid fa-user-plus w-4 text-center"></i> Daftar Akun
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-xl border-t border-gray-200 dark:border-gray-800 flex flex-col p-4 gap-2 z-40">
        <?php if(!$isLoggedIn || $role == 'user'): ?>
            <a href="/" class="<?= $currentUrl == '' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition flex items-center gap-3">
                <i class="fa-solid fa-house"></i> Beranda
            </a>
            <?php if($isLoggedIn && $role == 'user'): ?>
            <a href="/favorite" class="<?= $currentUrl == 'favorite' ? 'bg-pink-50 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition flex items-center justify-between">
                <div class="flex items-center gap-3"><i class="fa-solid fa-heart"></i> Wishlist</div>
                <?php if($favoriteCount > 0): ?>
                    <span class="bg-rose-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $favoriteCount; ?></span>
                <?php endif; ?>
            </a>
            <a href="/my-bookings" class="<?= $currentUrl == 'my-bookings' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition flex items-center gap-3">
                <i class="fa-solid fa-ticket"></i> Tiket Saya
            </a>
            <?php endif; ?>
        <?php elseif($role == 'organizer'): ?>
            <a href="/organizer" class="<?= $currentUrl == 'organizer' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Dashboard</a>
            <a href="/organizer/my-events" class="<?= $currentUrl == 'organizer/my-events' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Acara Saya</a>
            <a href="/event/create" class="<?= $currentUrl == 'event/create' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Buat Acara</a>
            <a href="/organizer/bookings" class="<?= $currentUrl == 'organizer/bookings' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Kelola Pesanan</a>
        <?php elseif($role == 'admin'): ?>
            <a href="/admin" class="<?= $currentUrl == 'admin' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Dashboard</a>
            <a href="/event" class="<?= $currentUrl == 'event' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Semua Acara</a>
            <a href="/admin/users" class="<?= $currentUrl == 'admin/users' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Pengguna</a>
            <a href="/admin/categories" class="<?= $currentUrl == 'admin/categories' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300'; ?> px-4 py-3 rounded-xl transition">Kategori</a>
        <?php endif; ?>
    </div>
</nav>

<script>
    const themeIconFA = document.getElementById('themeIconFA');
    const themeText = document.getElementById('themeText');

    function updateThemeUI(isDark) {
        if(isDark) {
            document.documentElement.classList.add('dark');
            if(themeIconFA) {
                themeIconFA.classList.remove('fa-moon');
                themeIconFA.classList.add('fa-sun');
                themeText.innerText = 'Mode Terang';
            }
        } else {
            document.documentElement.classList.remove('dark');
            if(themeIconFA) {
                themeIconFA.classList.remove('fa-sun');
                themeIconFA.classList.add('fa-moon');
                themeText.innerText = 'Mode Gelap';
            }
        }
    }

    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        updateThemeUI(true);
    } else {
        updateThemeUI(false);
    }

    function toggleTheme() {
        const isDark = !document.documentElement.classList.contains('dark');
        localStorage.theme = isDark ? 'dark' : 'light';
        updateThemeUI(isDark);
    }

    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
        document.getElementById('userDropdown').classList.add('hidden');
    }

    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
        document.getElementById('mobileMenu').classList.add('hidden');
    }

    // FIX DI SINI: Deteksi klik luar menggunakan ID absolut tombol profil, bukan relasi elemen sekitarnya
    window.addEventListener('click', function(e) {
        const userDropdown = document.getElementById('userDropdown');
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        
        if (userDropdown && userDropdownBtn) {
            if (!userDropdownBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        }
    });
</script>