<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 space-y-6">

    <a href="/" class="text-blue-500 hover:text-blue-700 font-semibold inline-block">
        ← Kembali
    </a>

    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl overflow-hidden">

        <?php if($event['image']): ?>
            <img src="/uploads/<?= esc($event['image'], 'url') ?>" class="w-full h-[400px] object-cover">
        <?php else: ?>
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-[400px] object-cover">
        <?php endif; ?>

        <div class="p-6 md:p-8">

            <?php if(isset($event['category_name'])): ?>
                <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 px-4 py-1 rounded-full text-sm font-medium">
                    <?= esc($event['category_name']); ?>
                </span>
            <?php endif; ?>

            <h1 class="text-3xl md:text-4xl font-bold mt-4 mb-4 text-gray-800 dark:text-white">
                <?= esc($event['title']) ?>
            </h1>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Location</p>
                    <p class="font-bold text-base md:text-lg">
                        📍 <?= esc($event['location']) ?>
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Event Date</p>
                    <p class="font-bold text-base md:text-lg">
                        📅 <?= esc($event['date']) ?>
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Total Capacity</p>
                    <p class="font-bold text-base md:text-lg">
                        🎟 <?= $event['quota']; ?> Seats
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Sisa Slot</p>
                    <p class="font-bold text-base md:text-lg text-blue-600 dark:text-blue-400">
                        🔥 <?= $remainingSeat; ?> Slot
                    </p>
                </div>

            </div>

            <div class="bg-gray-50 dark:bg-gray-800/40 rounded-xl p-4 mb-6 flex items-center justify-between">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Status Registrasi:</span>
                <?php if($isBooked): ?>
                    <span class="font-bold text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-lg">✔ Already Booked</span>
                <?php else: ?>
                    <span class="font-bold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-3 py-1 rounded-lg">Available</span>
                <?php endif; ?>
            </div>

            <div class="mb-8 border-t border-gray-100 dark:border-gray-800 pt-6">
                <h2 class="text-2xl font-bold mb-3 text-gray-800 dark:text-white">
                    About Event
                </h2>
                <p class="text-gray-700 dark:text-gray-200 leading-8">
                    <?= esc($event['description']) ?>
                </p>
            </div>

            <div class="flex flex-wrap gap-4 items-center border-t border-gray-100 dark:border-gray-800 pt-6">
                <?php if(session()->get('id') && session()->get('role') != 'admin'): ?>
                    
                    <?php if(!$isBooked && $remainingSeat > 0): ?>
                        <a href="/book/<?= $event['id'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all transform active:scale-[0.98]">
                            🎟 Book Now
                        </a>
                    <?php elseif(!$isBooked && $remainingSeat <= 0): ?>
                        <button type="button" disabled class="bg-gray-400 dark:bg-gray-700 text-gray-200 dark:text-gray-400 px-8 py-4 rounded-xl inline-block text-lg font-semibold cursor-not-allowed shadow-none">
                            ❌ Sold Out
                        </button>
                    <?php else: ?>
                        <div class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-6 py-4 rounded-xl inline-block font-semibold">
                            ✔ Kamu sudah booking event ini
                        </div>
                    <?php endif; ?>

                    <?php if(!$isFavorite): ?>
                        <a href="/favorite/add/<?= $event['id'] ?>" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all transform active:scale-[0.98]">
                            ❤️ Add Wishlist
                        </a>
                    <?php else: ?>
                        <a href="/favorite/remove/<?= $event['id'] ?>" class="bg-gray-700 hover:bg-gray-800 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all transform active:scale-[0.98]">
                            ❌ Remove Wishlist
                        </a>
                    <?php endif; ?>

                <?php else: ?>
                    <a href="/login" class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-md w-full md:w-auto text-center">
                        Login untuk Booking
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-6 md:p-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
            💬 Discussion
        </h2>

        <?php if(session()->get('logged_in')): ?>
            <form action="/comment/store/<?= $event['id']; ?>" method="post" class="mb-8">
                <textarea name="comment" rows="4" placeholder="Tulis komentar..." class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 rounded-xl mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-white" required></textarea>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-medium transition-colors">
                    Kirim Komentar
                </button>
            </form>
        <?php else: ?>
            <div class="bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400 p-4 rounded-xl mb-6 font-medium">
                Login untuk ikut diskusi
            </div>
        <?php endif; ?>

        <?php if(count($comments) > 0): ?>
            <div class="space-y-4">
                <?php foreach($comments as $c): ?>
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-5 border border-gray-100 dark:border-gray-800">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-white"><?= esc($c['name']); ?></h3>
                                <p class="text-xs text-gray-400 mt-0.5"><?= esc($c['created_at']); ?></p>
                            </div>
                            <?php if(session()->get('id') == $c['user_id']): ?>
                                <a href="/comment/delete/<?= $c['id']; ?>" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</a>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-700 dark:text-gray-200 leading-7">
                            <?= esc($c['comment']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 dark:bg-gray-800/30 p-8 rounded-xl text-center text-gray-400">
                Belum ada komentar 😢
            </div>
        <?php endif; ?>
    </div>

</div>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

</body>
</html>