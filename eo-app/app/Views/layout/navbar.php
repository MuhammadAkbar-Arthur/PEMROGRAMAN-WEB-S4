<?php
$db = \Config\Database::connect();
$currentUrl = trim(service('uri')->getPath(), '/');
$isLoggedIn = session()->get('logged_in');
$role = session()->get('role');
$favoriteCount = 0;

// Counter wishlist khusus untuk role 'user'
if ($isLoggedIn && $role == 'user') {
    $favoriteCount = $db->table('favorites')
        ->where('user_id', session()->get('id'))
        ->countAllResults();
}
?>

<nav class="bg-gray-900/95 dark:bg-black/95 backdrop-blur-md text-white shadow-lg transition duration-300 sticky top-0 z-50 border-b border-gray-800">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <a href="/" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400 z-50 tracking-tight">
            EO Management.
        </a>

        <button onclick="toggleMenu()" class="md:hidden bg-gray-800 hover:bg-gray-700 text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 px-3 py-2 rounded-lg relative z-50 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div id="mobileMenu" class="hidden md:flex md:items-center md:justify-between md:flex-1 md:ml-10
                    absolute md:static top-full left-0 w-full md:w-auto
                    bg-gray-900/95 md:bg-transparent backdrop-blur-md md:backdrop-blur-none
                    shadow-xl md:shadow-none flex-col md:flex-row
                    p-6 md:p-0 gap-6 md:gap-0 z-40 border-b md:border-none border-gray-800 transition-all duration-300">

            <div class="flex flex-col md:flex-row md:items-center justify-center md:flex-1 gap-3 md:gap-4 w-full md:w-auto text-sm font-medium">
                
                <button onclick="toggleTheme()" class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-3 py-2 rounded-lg transition w-full md:w-auto text-left md:text-center flex items-center justify-center gap-2">
                    <span id="themeIcon">🌙</span> <span class="md:hidden">Toggle Theme</span>
                </button>

                <?php if(!$isLoggedIn): ?>
                    <a href="/" class="w-full md:w-auto <?= $currentUrl == '' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Home</a>
                
                <?php elseif($role == 'user'): ?>
                    <a href="/" class="w-full md:w-auto <?= $currentUrl == '' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Home</a>
                    
                    <a href="/favorite" class="relative w-full md:w-auto <?= $currentUrl == 'favorite' ? 'bg-pink-600 text-white shadow-md shadow-pink-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition flex items-center justify-between md:justify-center">
                        Wishlist
                        <?php if($favoriteCount > 0): ?>
                            <span class="md:absolute md:-top-2 md:-right-2 bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                <?= $favoriteCount; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <a href="/my-bookings" class="w-full md:w-auto <?= $currentUrl == 'my-bookings' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">My Booking</a>
                    
                    <a href="/profile" class="w-full md:w-auto <?= $currentUrl == 'profile' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Profile</a>

                <?php elseif($role == 'organizer'): ?>
                    <a href="/organizer" class="w-full md:w-auto <?= $currentUrl == 'organizer' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Dashboard</a>
                    <a href="/organizer/my-events" class="w-full md:w-auto <?= $currentUrl == 'organizer/my-events' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">My Events</a>
                    <a href="/event/create" class="w-full md:w-auto <?= $currentUrl == 'event/create' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Create Event</a>
                    <a href="/organizer/bookings" class="w-full md:w-auto <?= $currentUrl == 'organizer/bookings' ? 'bg-purple-600 text-white shadow-md shadow-purple-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Manage Bookings</a>
                    <a href="/profile" class="w-full md:w-auto <?= $currentUrl == 'profile' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Profile</a>

                <?php elseif($role == 'admin'): ?>
                    <a href="/admin" class="w-full md:w-auto <?= $currentUrl == 'admin' ? 'bg-amber-600 text-white shadow-md shadow-amber-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Dashboard</a>
                    <a href="/event" class="w-full md:w-auto <?= $currentUrl == 'event' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Kelola Event</a>
                    <a href="/admin/users" class="w-full md:w-auto <?= $currentUrl == 'admin/users' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Kelola User</a>
                    <a href="/admin/categories" class="w-full md:w-auto <?= $currentUrl == 'admin/categories' ? 'bg-purple-600 text-white shadow-md shadow-purple-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Kelola Category</a>
                    <a href="/admin/analytics" class="w-full md:w-auto <?= $currentUrl == 'admin/analytics' ? 'bg-pink-600 text-white shadow-md shadow-pink-500/20' : 'text-gray-300 hover:text-white hover:bg-gray-800'; ?> px-4 py-2 rounded-lg transition">Analytics</a>
                <?php endif; ?>
            </div>

            <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto border-t border-gray-800 md:border-none pt-6 md:pt-0 mt-2 md:mt-0">
                <?php if($isLoggedIn): ?>
                    <span class="text-gray-400 text-sm hidden lg:block mr-2">
                        Hi, <span class="font-bold text-white"><?= esc(session()->get('name')); ?></span>
                    </span>
                    <a href="/logout" class="bg-rose-500/10 text-rose-500 border border-rose-500/50 hover:bg-rose-500 hover:text-white px-5 py-2 rounded-lg transition text-center w-full md:w-auto font-medium text-sm">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/login" class="text-gray-300 hover:text-white px-4 py-2 rounded-lg transition text-center w-full md:w-auto text-sm font-medium hover:bg-gray-800">
                        Login
                    </a>
                    <a href="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition text-center w-full md:w-auto text-sm font-medium shadow-md shadow-blue-500/20">
                        Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        document.getElementById('themeIcon').innerText = '☀️';
    } else {
        document.documentElement.classList.remove('dark');
        document.getElementById('themeIcon').innerText = '🌙';
    }

    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
        if (document.documentElement.classList.contains('dark')) {
            localStorage.theme = 'dark';
            document.getElementById('themeIcon').innerText = '☀️';
        } else {
            localStorage.theme = 'light';
            document.getElementById('themeIcon').innerText = '🌙';
        }
    }

    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>