<!DOCTYPE html>
<html>
<head>

    <title>My Wishlist</title>

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
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold">
                ❤️ My Wishlist
            </h1>

            <p class="text-gray-500 mt-2">
                Semua event favorit kamu ada di sini
            </p>

        </div>

        <a href="/"
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl">

           ← Back Home

        </a>

    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($favorites)): ?>

        <div class="bg-white rounded-2xl shadow-lg p-10 text-center">

            <h2 class="text-2xl font-bold mb-3">
                Wishlist masih kosong 😢
            </h2>

            <p class="text-gray-500 mb-6">
                Yuk tambahkan event favoritmu sekarang
            </p>

            <a href="/"
               class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl">

               Explore Events

            </a>

        </div>

    <?php else: ?>

    <!-- CARD GRID -->
    <div class="grid md:grid-cols-3 gap-6">

        <?php foreach($favorites as $f): ?>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden
                    hover:-translate-y-2 hover:shadow-2xl
                    transition-all duration-300">

            <!-- IMAGE -->
            <?php if($f['image']): ?>

                <img src="/uploads/<?= $f['image']; ?>"
                     class="w-full h-52 object-cover">

            <?php else: ?>

                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
                     class="w-full h-52 object-cover">

            <?php endif; ?>

            <div class="p-5">

                <!-- TITLE -->
                <h2 class="text-2xl font-bold mb-2">

                    <?= $f['title']; ?>

                </h2>

                <!-- LOCATION -->
                <p class="text-gray-600 mb-2">

                    📍 <?= $f['location']; ?>

                </p>

                <!-- DATE -->
                <p class="text-gray-500 mb-5">

                    📅 <?= $f['date']; ?>

                </p>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <a href="/event/<?= $f['event_id']; ?>"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">

                       Detail

                    </a>

                    <a href="/favorite/remove/<?= $f['event_id']; ?>"
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                       Remove

                    </a>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

</div>

<?= view('layout/footer'); ?>

</body>
</html>