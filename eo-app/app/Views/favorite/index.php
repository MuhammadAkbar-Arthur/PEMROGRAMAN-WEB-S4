<!DOCTYPE html>
<html lang="id">
<head>
    <title>My Wishlist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 min-h-screen">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                ❤️ My Wishlist
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Semua event favorit kamu tersimpan dengan aman di sini
            </p>
        </div>
        <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow-md transition font-medium">
            ← Back Home
        </a>
    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($favorites)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-10 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-4">😢</div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Wishlist masih kosong
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                Yuk jelajahi dan tambahkan event favoritmu sekarang!
            </p>
            <a href="/" class="inline-block bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-xl font-medium shadow-lg shadow-pink-500/30 transition transform hover:-translate-y-1">
                Explore Events
            </a>
        </div>
    <?php else: ?>

    <!-- CARD GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($favorites as $f): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300 flex flex-col h-full">

            <!-- IMAGE DENGAN FALLBACK SINKRON -->
            <?php if($f['image']): ?>
                <img src="/uploads/<?= esc($f['image'], 'url'); ?>" class="w-full h-52 object-cover">
            <?php else: ?>
                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-52 object-cover filter grayscale-[30%]">
            <?php endif; ?>

            <div class="p-6 flex flex-col flex-1">
                <!-- TITLE -->
                <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white line-clamp-2">
                    <?= esc($f['title']); ?>
                </h2>

                <!-- DETAILS -->
                <div class="mt-auto space-y-2 mb-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📍</span> <span class="truncate"><?= esc($f['location']); ?></span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📅</span> <span><?= esc($f['date']); ?></span>
                    </p>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-3 mt-auto">
                    <a href="/event/<?= $f['event_id']; ?>" class="flex-1 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white text-center px-4 py-2.5 rounded-xl font-medium transition duration-200 border border-transparent dark:border-gray-700">
                        Detail
                    </a>
                    <a href="/favorite/remove/<?= $f['event_id']; ?>" onclick="return confirmDelete(event)" class="flex-1 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-950/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white border border-transparent dark:border-rose-900 text-center px-4 py-2.5 rounded-xl font-medium transition duration-200">
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

<script>
function confirmDelete(event) {
    event.preventDefault();
    const url = event.currentTarget.href;

    Swal.fire({
        title: 'Hapus dari Wishlist?',
        text: 'Event ini akan dihapus dari daftar favoritmu.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Ya, Hapus!',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    }).then((result) => {
        if(result.isConfirmed) {
            window.location.href = url;
        }
    });
    return false;
}
</script>

<!-- SWEETALERT NOTIFICATIONS -->
<?php if(session()->getFlashdata('success')): ?>
<script>
Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: <?= json_encode(session()->getFlashdata('success')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: <?= json_encode(session()->getFlashdata('error')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });
</script>
<?php endif; ?>

</body>
</html>