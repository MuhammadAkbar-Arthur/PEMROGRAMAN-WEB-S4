<!DOCTYPE html>
<html>
<head>

    <title>Detail Event</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6">

    <!-- BACK BUTTON -->
    <a href="/"
       class="text-blue-500 hover:text-blue-700 font-semibold">

       ← Kembali

    </a>

    <!-- HERO -->
    <div class="bg-white dark:bg-gray-900 shadow rounded p-6">

        <!-- IMAGE -->
        <?php if($event['image']): ?>

            <img src="/uploads/<?= $event['image'] ?>"
                 class="w-full h-[400px] object-cover">

        <?php else: ?>

            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
                 class="w-full h-[400px] object-cover">

        <?php endif; ?>

        <div class="p-8">

            <!-- CATEGORY -->
            <?php if(isset($event['category_name'])): ?>

                <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">

                    <?= $event['category_name']; ?>

                </span>

            <?php endif; ?>

            <!-- TITLE -->
            <h1 class="text-4xl font-bold mt-4 mb-4">

                <?= $event['title'] ?>

            </h1>

            <!-- INFO GRID -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <!-- LOCATION -->
                <div class="bg-gray-100 rounded-xl p-4">

                    <p class="text-gray-500 text-sm">
                        Location
                    </p>

                    <p class="font-bold text-lg">
                        📍 <?= $event['location'] ?>
                    </p>

                </div>

                <!-- DATE -->
                <div class="bg-gray-100 rounded-xl p-4">

                    <p class="text-gray-500 text-sm">
                        Event Date
                    </p>

                    <p class="font-bold text-lg">
                        📅 <?= $event['date'] ?>
                    </p>

                </div>
                <!-- QUOTA -->
                <div class="bg-gray-100 rounded-xl p-4">

                    <p class="text-gray-500 text-sm">
                        Seat Available
                    </p>

                    <p class="font-bold text-lg">

                        🎟 <?= $remainingSeat ?> / <?= $event['quota']; ?>

                    </p>

                </div>
                <!-- STATUS -->
                <div class="bg-gray-100 rounded-xl p-4">

                    <p class="text-gray-500 text-sm">
                        Booking Status
                    </p>

                    <?php if($isBooked): ?>

                        <p class="font-bold text-green-600">
                            ✔ Already Booked
                        </p>

                    <?php else: ?>

                        <p class="font-bold text-orange-500">
                            Available
                        </p>

                    <?php endif; ?>

                </div>

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-8">

                <h2 class="text-2xl font-bold mb-3">
                    About Event
                </h2>

                <p class="text-gray-700 dark:text-gray-200 leading-8">

                    <?= $event['description'] ?>

                </p>

            </div>
            <!-- FAVORITE BUTTON -->
            <div class="mb-6">

                <?php if(session()->get('logged_in')): ?>

                    <?php if(!$isFavorite): ?>

                        <a href="/favorite/add/<?= $event['id']; ?>"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl inline-block font-semibold transition">

                        ❤️ Add Wishlist

                        </a>

                    <?php else: ?>

                        <a href="/favorite/remove/<?= $event['id']; ?>"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl inline-block font-semibold transition">

                        💔 Remove Wishlist

                        </a>

                    <?php endif; ?>

                <?php endif; ?>

            </div>
            <!-- ACTION BUTTON -->
            <div class="flex flex-wrap gap-4 items-center">

                <?php if(session()->get('id')): ?>

                    <!-- BOOKING -->
                    <?php if(!$isBooked && !$isFull): ?>

                        <a href="/book/<?= $event['id'] ?>"
                        class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all">

                        🎟 Book Now

                        </a>
                    <?php elseif($isFull): ?>

                        <div class="bg-red-100 text-red-700 px-6 py-4 rounded-xl inline-block font-semibold">

                            ❌ Event Full

                        </div>
                    <?php else: ?>

                        <div class="bg-green-100 text-green-700 px-6 py-4 rounded-xl inline-block font-semibold">

                            ✔ Kamu sudah booking event ini

                        </div>

                    <?php endif; ?>

                    <!-- FAVORITE -->
                    <?php if(!$isFavorite): ?>

                        <a href="/favorite/add/<?= $event['id'] ?>"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all">

                        ❤️ Add Wishlist

                        </a>

                    <?php else: ?>

                        <a href="/favorite/remove/<?= $event['id'] ?>"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all">

                        ❌ Remove Wishlist

                        </a>

                    <?php endif; ?>

                <?php else: ?>

                    <a href="/login"
                    class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold">

                    Login untuk Booking

                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<!-- COMMENT SECTION -->
<div class="bg-white dark:bg-gray-900 shadow rounded p-6">

    <h2 class="text-3xl font-bold mb-6">

        💬 Discussion

    </h2>

    <!-- FORM -->
    <?php if(session()->get('logged_in')): ?>

        <form action="/comment/store/<?= $event['id']; ?>"
              method="post"
              class="mb-8">

            <textarea
                name="comment"
                rows="4"
                placeholder="Tulis komentar..."
                class="w-full border p-4 rounded-xl mb-4"
                required></textarea>

            <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

                Kirim Komentar

            </button>

        </form>

    <?php else: ?>

        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">

            Login untuk ikut diskusi

        </div>

    <?php endif; ?>

    <!-- COMMENTS -->
    <?php if(count($comments) > 0): ?>

        <div class="space-y-4">

            <?php foreach($comments as $c): ?>

                <div class="bg-gray-100 rounded-xl p-5">

                    <div class="flex justify-between items-center mb-2">

                        <div>

                            <h3 class="font-bold">

                                <?= $c['name']; ?>

                            </h3>

                            <p class="text-sm text-gray-500">

                                <?= $c['created_at']; ?>

                            </p>

                        </div>

                        <?php if(session()->get('id') == $c['user_id']): ?>

                            <a href="/comment/delete/<?= $c['id']; ?>"
                               class="text-red-500 hover:text-red-700">

                               Hapus

                            </a>

                        <?php endif; ?>

                    </div>

                    <p class="text-gray-700 dark:text-gray-200 leading-7">

                        <?= $c['comment']; ?>

                    </p>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="bg-gray-100 p-6 rounded-xl text-center text-gray-500">

            Belum ada komentar 😢

        </div>

    <?php endif; ?>

</div>
<?= view('layout/footer'); ?>

<?php if(session()->getFlashdata('success')): ?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil 🎉',

    text: '<?= session()->getFlashdata('success'); ?>',

    confirmButtonColor: '#2563eb'

});

</script>

<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>

<script>

Swal.fire({

    icon: 'error',

    title: 'Oops 😢',

    text: '<?= session()->getFlashdata('error'); ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>