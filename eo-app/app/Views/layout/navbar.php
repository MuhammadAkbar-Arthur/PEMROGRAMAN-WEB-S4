<?php

$db = \Config\Database::connect();

$favoriteCount = 0;

if(session()->get('logged_in')) {

    $favoriteCount = $db->table('favorites')
        ->where('user_id', session()->get('id'))
        ->countAllResults();
}

?>

<nav class="bg-gray-900 dark:bg-black text-white shadow transition duration-300">

    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="/"
           class="text-2xl font-bold text-blue-400">

           Event Organizer

        </a>
        <!-- MOBILE BUTTON -->
        <button
            onclick="toggleMenu()"
            class="md:hidden bg-gray-700 px-3 py-2 rounded">

            ☰

        </button>
        <!-- MENU -->
        <div class="hidden md:flex gap-4 items-center flex-wrap" id="mobileMenu">

            <!-- DARK MODE -->
            <button
                onclick="toggleTheme()"
                class="bg-gray-700 hover:bg-gray-600 px-3 py-2 rounded transition">

                🌙

            </button>
        

            <a href="/"
               class="hover:text-blue-400 transition">

               Home

            </a>

            <?php if(session()->get('logged_in')): ?>

                <!-- WISHLIST -->
                <a href="/favorite"
                   class="relative hover:text-pink-400 transition">

                   ❤️ Wishlist

                   <?php if($favoriteCount > 0): ?>

                        <span class="absolute -top-3 -right-4 bg-red-500 text-white text-xs px-2 py-1 rounded-full">

                            <?= $favoriteCount; ?>

                        </span>

                   <?php endif; ?>

                </a>
                <a href="/dashboard"
                    class="hover:text-blue-400">
                    Dashboard
                </a>
                <!-- BOOKING -->
                <a href="/my-bookings"
                   class="hover:text-blue-400 transition">

                   My Booking

                </a>

                <!-- PROFILE -->
                <a href="/profile"
                    class="hover:text-blue-400 transition">

                    Profile

                </a>

                <?php if(session()->get('role') == 'admin'): ?>

                    <!-- ADMIN -->
                    <a href="/admin"
                       class="hover:text-yellow-400 transition">

                       Admin

                    </a>

                    <!-- EVENT -->
                    <a href="/event"
                       class="hover:text-green-400 transition">

                       Kelola Event

                    </a>

                <?php endif; ?>

                <!-- USER -->
                <span class="text-gray-300">

                    Hi, <?= esc(session()->get('name')); ?>

                </span>

                <!-- LOGOUT -->
                <a href="/logout"
                   class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded transition">

                   Logout

                </a>

            <?php else: ?>

                <!-- LOGIN -->
                <a href="/login"
                   class="bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded transition">

                   Login

                </a>

                <!-- REGISTER -->
                <a href="/register"
                   class="bg-green-500 hover:bg-green-600 px-3 py-2 rounded transition">

                   Register

                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>
<script>

    // LOAD THEME
    if (localStorage.theme === 'dark') {

        document.documentElement.classList.add('dark');

    }

    // TOGGLE
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
    <script>

    function toggleMenu()
    {
        const menu = document.getElementById('mobileMenu');

        menu.classList.toggle('hidden');

        menu.classList.toggle('flex');

        menu.classList.toggle('flex-col');

        menu.classList.toggle('absolute');

        menu.classList.toggle('top-20');

        menu.classList.toggle('right-5');

        menu.classList.toggle('bg-gray-900');

        menu.classList.toggle('p-5');

        menu.classList.toggle('rounded-lg');

    }

    </script>

</script>