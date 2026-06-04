<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara Saya - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12">

    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-calendar-day text-blue-600 dark:text-blue-400"></i> Acara Saya
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Kelola dan pantau semua acara yang telah Anda buat di platform ini.
            </p>
        </div>
        <a href="/event/create" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1 flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-circle-plus text-lg"></i> Buat Acara Baru
        </a>
    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($events)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-3xl p-12 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-6 text-gray-300 dark:text-gray-700">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Belum Ada Acara
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Tampaknya Anda belum menyelenggarakan acara apa pun. Mulai buat acara pertama Anda sekarang!
            </p>
            <a href="/event/create" class="inline-flex bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1 items-center gap-2">
                <i class="fa-solid fa-rocket"></i> Buat Acara Sekarang
            </a>
        </div>
    <?php else: ?>
        
        <!-- CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            <?php foreach($events as $e): ?>
                <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-xl border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full group relative">
                    
                    <!-- Kategori Badge (Absolute) -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-white/90 backdrop-blur-sm dark:bg-gray-900/90 text-blue-600 dark:text-blue-400 border border-gray-100 dark:border-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm">
                            <?= esc($e['category_name']); ?>
                        </span>
                    </div>

                    <!-- Image with Fallback -->
                    <div class="relative overflow-hidden aspect-video">
                        <?php if($e['image']): ?>
                            <img src="/uploads/<?= esc($e['image'], 'url'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-full object-cover filter grayscale-[30%] group-hover:scale-110 transition duration-500">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">
                            <?= esc($e['title']); ?>
                        </h2>
                        
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                            <?= esc($e['description']); ?>
                        </p>
                        
                        <div class="mt-auto space-y-2 mb-5">
                            <p class="text-gray-600 dark:text-gray-300 text-sm flex items-center gap-2.5 font-medium">
                                <i class="fa-solid fa-location-dot w-4 text-center text-rose-500"></i>
                                <span class="truncate"><?= esc($e['location']); ?></span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm flex items-center gap-2.5 font-medium">
                                <i class="fa-regular fa-calendar w-4 text-center text-blue-500"></i>
                                <?= esc($e['date']); ?>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300 text-sm flex items-center gap-2.5 font-medium">
                                <i class="fa-solid fa-users w-4 text-center text-emerald-500"></i>
                                Kuota: <span class="font-bold text-gray-900 dark:text-white"><?= esc($e['quota']); ?></span>
                            </p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-3 gap-2 mt-auto border-t border-gray-100 dark:border-gray-800 pt-4">
                            <!-- Tombol Lihat -->
                            <a href="/event/<?= $e['id']; ?>" class="flex flex-col items-center justify-center gap-1 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white py-2 rounded-xl text-[11px] font-bold transition uppercase tracking-wide">
                                <i class="fa-solid fa-eye text-sm"></i> Lihat
                            </a>

                            <!-- Tombol Edit -->
                            <a href="/event/edit/<?= $e['id']; ?>" class="flex flex-col items-center justify-center gap-1 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-500 dark:hover:text-white py-2 rounded-xl text-[11px] font-bold transition uppercase tracking-wide">
                                <i class="fa-solid fa-pen-to-square text-sm"></i> Edit
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <a href="/event/delete/<?= $e['id']; ?>" class="delete-btn flex flex-col items-center justify-center gap-1 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white py-2 rounded-xl text-[11px] font-bold transition uppercase tracking-wide">
                                <i class="fa-solid fa-trash-can text-sm"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('href');

        Swal.fire({
            title: 'Yakin Ingin Menghapus?',
            text: "Acara yang dihapus tidak dapat dikembalikan beserta semua tiket yang terkait!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // rose-600
            cancelButtonColor: '#6b7280',  // gray-500
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-2"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
            customClass: {
                confirmButton: 'rounded-xl',
                cancelButton: 'rounded-xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
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