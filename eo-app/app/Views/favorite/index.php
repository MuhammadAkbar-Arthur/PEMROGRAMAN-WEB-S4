<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 min-h-screen flex-grow mt-4">

    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-rose-500 dark:from-pink-400 dark:to-rose-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-heart text-pink-500 dark:text-pink-400"></i> Wishlist Saya
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Semua acara favorit yang kamu simpan ada di sini. Jangan sampai kehabisan tiket!
            </p>
        </div>
        <a href="/" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- JIKA DATA KOSONG (EMPTY STATE) -->
    <?php if(empty($favorites)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-dashed border-gray-300 dark:border-gray-700 rounded-3xl p-12 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-6 text-gray-300 dark:text-gray-700">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Wishlist Masih Kosong
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Yuk jelajahi berbagai acara menarik dan simpan yang kamu suka untuk dibeli nanti!
            </p>
            <a href="/" class="inline-flex bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-pink-500/30 transition transform hover:-translate-y-1 items-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> Eksplor Acara
            </a>
        </div>
    <?php else: ?>

    <!-- CARD GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach($favorites as $f): ?>
        <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full group relative">

            <!-- BADGE FAVORIT (HEART) -->
            <div class="absolute top-4 right-4 z-10">
                <div class="bg-white/90 backdrop-blur-sm dark:bg-gray-900/90 w-10 h-10 flex items-center justify-center rounded-full shadow-lg text-rose-500 border border-gray-100 dark:border-gray-700">
                    <i class="fa-solid fa-heart text-xl"></i>
                </div>
            </div>

            <!-- IMAGE DENGAN FALLBACK SINKRON -->
            <div class="relative overflow-hidden aspect-video">
                <?php if($f['image']): ?>
                    <img src="/uploads/<?= esc($f['image'], 'url'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-full object-cover filter grayscale-[30%] group-hover:scale-110 transition duration-500">
                <?php endif; ?>
                <!-- Overlay Gradien Hitam Bawah -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
            </div>

            <div class="p-5 flex flex-col flex-1">
                <!-- TITLE -->
                <h2 class="text-lg font-bold mb-3 text-gray-900 dark:text-white line-clamp-2 leading-tight">
                    <?= esc($f['title']); ?>
                </h2>

                <!-- DETAILS -->
                <div class="mt-auto space-y-2 mb-6">
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2.5 font-medium">
                        <i class="fa-regular fa-calendar w-4 text-center text-blue-500"></i>
                        <span><?= esc($f['date']); ?></span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2.5 font-medium">
                        <i class="fa-solid fa-location-dot w-4 text-center text-rose-500"></i>
                        <span class="truncate"><?= esc($f['location']); ?></span>
                    </p>
                </div>

                <!-- BUTTONS -->
                <div class="flex gap-2 mt-auto border-t border-gray-100 dark:border-gray-800 pt-4">
                    <a href="/event/<?= $f['event_id']; ?>" class="flex-1 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white text-center px-4 py-2.5 rounded-xl text-sm font-bold transition duration-200 flex justify-center items-center gap-2">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                    <a href="/favorite/remove/<?= $f['event_id']; ?>" onclick="return confirmDelete(event)" class="w-12 flex-shrink-0 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white text-center flex items-center justify-center rounded-xl transition duration-200" title="Hapus dari Wishlist">
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</main>

<?= view('layout/footer'); ?>

<script>
function confirmDelete(event) {
    event.preventDefault();
    const url = event.currentTarget.href;

    Swal.fire({
        title: 'Hapus dari Wishlist?',
        text: 'Acara ini akan dihapus dari daftar favoritmu.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fa-solid fa-trash-can mr-2"></i> Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
        customClass: {
            confirmButton: 'rounded-xl',
            cancelButton: 'rounded-xl'
        }
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