<?php

$db = \Config\Database::connect();

$favoriteCount = 0;

if(session()->get('logged_in')) {

    $favoriteCount = $db->table('favorites')
        ->where('user_id', session()->get('id'))
        ->countAllResults();
}

$currentUrl = trim(service('uri')->getPath(), '/');

?>

<nav class="bg-gray-900 dark:bg-black text-white shadow transition duration-300 relative z-50">

    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="/"
           class="text-2xl font-bold text-blue-400">

           Event Organizer

        </a>

        <!-- MOBILE BUTTON -->
        <button
            onclick="toggleMenu()"
            class="md:hidden bg-gray-700 px-3 py-2 rounded relative z-50">

            ☰

        </button>

        <div id="mobileMenu"
            class="hidden md:flex flex-col md:flex-row md:flex-1
                   items-start md:items-center
                   absolute md:static
                   top-full left-0 right-0
                   w-full md:w-auto
                   bg-gray-900 md:bg-transparent
                   p-5 md:p-0
                   shadow-lg md:shadow-none
                   z-50">

            <div class="flex flex-col md:flex-row flex-1 justify-center items-start md:items-center gap-4 md:gap-8 w-full md:w-auto mb-4 md:mb-0">
                
                <button
                    onclick="toggleTheme()"
                    class="bg-gray-700 hover:bg-gray-600 px-3 py-2 rounded transition w-full md:w-auto text-left md:text-center">
                    🌙
                </button>

                <a href="/"
                   class="w-full md:w-auto <?= $currentUrl == '' ? 'bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-blue-400 px-3 py-2 block'; ?> transition">
                   Home
                </a>

                <?php if(session()->get('logged_in')): ?>
                    <?php if(session()->get('role') != 'admin'): ?>
                        <a href="/favorite"
                           class="relative w-full md:w-auto <?= $currentUrl == 'favorite' ? 'bg-pink-500 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-pink-400 px-3 py-2 block'; ?> transition">
                           Wishlist
                           <?php if($favoriteCount > 0): ?>
                                <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    <?= $favoriteCount; ?>
                                </span>
                           <?php endif; ?>
                        </a>

                        <a href="/my-bookings"
                           class="w-full md:w-auto <?= $currentUrl == 'my-bookings' ? 'bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-blue-400 px-3 py-2 block'; ?> transition">
                           My Booking
                        </a>
                    <?php endif; ?>

                    <a href="/profile"
                        class="w-full md:w-auto <?= $currentUrl == 'profile' ? 'bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-blue-400 px-3 py-2 block'; ?> transition">
                        Profile
                    </a>

                    <?php if(session()->get('role') == 'admin'): ?>
                        <a href="/admin"
                           class="w-full md:w-auto <?= $currentUrl == 'admin' ? 'bg-yellow-500 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-yellow-400 px-3 py-2 block'; ?> transition">
                           Admin
                        </a>

                        <a href="/event"
                           class="w-full md:w-auto <?= $currentUrl == 'event' ? 'bg-green-500 text-white px-3 py-2 rounded-lg font-semibold block' : 'hover:text-green-400 px-3 py-2 block'; ?> transition">
                           Kelola Event
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full md:w-auto border-t border-gray-700 md:border-none pt-4 md:pt-0">
                <?php if(session()->get('logged_in')): ?>
                    <span class="text-gray-300">
                        Hi, <?= esc(session()->get('name')); ?>
                    </span>

                    <a href="/logout"
                       class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded transition text-center w-full md:w-auto font-medium shadow-md">
                       Logout
                    </a>
                <?php else: ?>
                    <a href="/login"
                       class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded transition text-center w-full md:w-auto">
                       Login
                    </a>

                    <a href="/register"
                       class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded transition text-center w-full md:w-auto">
                       Register
                    </a>
                <?php endif; ?>
            </div>

        </div>

    </div>

</nav>

<script>

    // LOAD THEME
    if (localStorage.theme === 'dark') {

        document.documentElement.classList.add('dark');

    }

    // TOGGLE THEME
    function toggleTheme()
    {
        document.documentElement.classList.toggle('dark');

        if (
            document.documentElement.classList.contains('dark')
        ) {

            localStorage.theme = 'dark';

        } else {

            localStorage.theme = 'light';

        }
    }

    // MOBILE MENU
    function toggleMenu()
    {
        const menu = document.getElementById('mobileMenu');

        menu.classList.toggle('hidden');
    }

</script>