<!DOCTYPE html>
<html>
<head>

    <title>User Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>

</head>

<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <!-- HEADER -->
    <div class="mb-8">

        <h1 class="text-4xl font-bold mb-2">

            Welcome Back,
            <?= session()->get('name'); ?> 👋

        </h1>

        <p class="text-gray-500">

            Kelola booking dan wishlist event favoritmu.

        </p>

    </div>

    <!-- STATISTIC -->
    <div class="grid md:grid-cols-2 gap-6 mb-10">

        <!-- BOOKING -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500 mb-2">
                        Total Booking
                    </p>

                    <h2 class="text-5xl font-bold text-blue-500">

                        <?= $bookingTotal; ?>

                    </h2>

                </div>

                <div class="text-6xl">
                    🎟
                </div>

            </div>

        </div>

        <!-- FAVORITE -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500 mb-2">
                        Wishlist Event
                    </p>

                    <h2 class="text-5xl font-bold text-pink-500">

                        <?= $favoriteTotal; ?>

                    </h2>

                </div>

                <div class="text-6xl">
                    ❤️
                </div>

            </div>

        </div>

    </div>

    <!-- UPCOMING EVENT -->
    <div class="bg-white rounded-2xl shadow-xl p-8 mb-10">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">

                Upcoming Events

            </h2>

            <a href="/my-bookings"
               class="text-blue-500 hover:text-blue-700">

               View All

            </a>

        </div>

        <div class="grid md:grid-cols-3 gap-6">

            <?php if($upcoming): ?>

                <?php foreach($upcoming as $u): ?>

                    <div class="border rounded-xl overflow-hidden hover:shadow-lg transition">

                        <?php if($u['image']): ?>

                            <img src="/uploads/<?= $u['image']; ?>"
                                 class="w-full h-40 object-cover">

                        <?php endif; ?>

                        <div class="p-4">

                            <h3 class="font-bold text-lg mb-2">

                                <?= $u['title']; ?>

                            </h3>

                            <p class="text-gray-500 mb-2">

                                📍 <?= $u['location']; ?>

                            </p>

                            <p class="text-gray-500">

                                📅 <?= $u['date']; ?>

                            </p>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p class="text-gray-500">

                    Belum ada booking event.

                </p>

            <?php endif; ?>

        </div>

    </div>

    <!-- FAVORITE EVENT -->
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <div class="flex justify-between items-center mb-6">

            <h2 class="text-2xl font-bold">

                Recent Wishlist

            </h2>

            <a href="/favorites"
               class="text-pink-500 hover:text-pink-700">

               View All

            </a>

        </div>

        <div class="grid md:grid-cols-3 gap-6">

            <?php if($favorites): ?>

                <?php foreach($favorites as $f): ?>

                    <div class="border rounded-xl overflow-hidden hover:shadow-lg transition">

                        <?php if($f['image']): ?>

                            <img src="/uploads/<?= $f['image']; ?>"
                                 class="w-full h-40 object-cover">

                        <?php endif; ?>

                        <div class="p-4">

                            <h3 class="font-bold text-lg mb-2">

                                <?= $f['title']; ?>

                            </h3>

                            <p class="text-gray-500 mb-2">

                                📍 <?= $f['location']; ?>

                            </p>

                            <p class="text-gray-500">

                                📅 <?= $f['date']; ?>

                            </p>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p class="text-gray-500">

                    Wishlist masih kosong.

                </p>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= view('layout/footer'); ?>

</body>
</html>