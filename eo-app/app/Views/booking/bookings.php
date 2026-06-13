<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 dark:bg-slate-950 transition duration-300 text-slate-800 dark:text-slate-100 flex flex-col min-h-screen antialiased selection:bg-blue-500 selection:text-white">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 min-h-screen flex-grow mt-4">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-black tracking-tight text-blue-600 dark:text-blue-400 flex items-center gap-3.5">
                <span class="p-2.5 bg-blue-50 dark:bg-blue-950/50 rounded-2xl inline-flex text-blue-600 dark:text-blue-400 border border-blue-100/50 dark:border-blue-900/30">
                    <i class="fa-solid fa-ticket transform -rotate-12 text-2xl"></i>
                </span>
                Tiket Saya
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Pantau status pendaftaran dan unduh tiket acaramu di sini.
            </p>
        </div>
        <a href="/" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <?php if(empty($bookings)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-dashed border-gray-300 dark:border-gray-700 rounded-3xl p-12 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-6 text-gray-300 dark:text-gray-700">
                <i class="fa-solid fa-ticket-simple"></i>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Belum Ada Tiket yang Dipesan
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Yuk, eksplorasi berbagai acara menarik dan amankan kursimu sekarang!
            </p>
            <a href="/" class="inline-flex bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1 items-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i> Eksplor Acara
            </a>
        </div>
    <?php else: ?>

        <div class="hidden md:block bg-white dark:bg-gray-900 shadow-xl border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-800 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">
                    <tr>
                        <th class="p-5 w-16 text-center">No</th>
                        <th class="p-5">Nama Acara</th>
                        <th class="p-5">Tanggal</th>
                        <th class="p-5">Lokasi</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                    <?php $no = 1; ?>
                    <?php foreach($bookings as $b): ?>
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-gray-800/40 transition duration-200">
                        <td class="p-5 text-center font-bold text-gray-400 dark:text-gray-500">
                            <?= $no++; ?>
                        </td>
                        <td class="p-5 font-bold text-gray-900 dark:text-white">
                            <?= esc($b['title']); ?>
                        </td>
                        <td class="p-5 text-sm font-medium">
                            <i class="fa-regular fa-calendar text-gray-400 mr-2"></i> <?= esc($b['date']); ?>
                        </td>
                        <td class="p-5 text-sm font-medium">
                            <i class="fa-solid fa-location-dot text-blue-500 mr-2"></i> <?= esc($b['location']); ?>
                        </td>
                        <td class="p-5">
                            <?php if($b['status'] == 'pending'): ?>
                                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Menunggu
                                </span>
                            <?php elseif($b['status'] == 'approved'): ?>
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                </span>
                            <?php elseif($b['status'] == 'rejected'): ?>
                                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-5">
                            <div class="flex gap-2 items-center justify-end">
                                <?php if($b['status'] == 'approved'): ?>
                                    <a href="/ticket/<?= $b['id'] ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                                        <i class="fa-solid fa-download"></i> Unduh
                                    </a>
                                <?php else: ?>
                                    <button class="bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 dark:border-gray-700 border px-4 py-2 rounded-xl text-sm font-bold cursor-not-allowed flex items-center gap-2" disabled>
                                        <i class="fa-solid fa-lock"></i> Terkunci
                                    </button>
                                <?php endif; ?>

                                <?php if($b['status'] == 'pending'): ?>
                                <form action="/booking/delete/<?= $b['id']; ?>" method="post" class="inline m-0 p-0">
                                    <?= csrf_field(); ?>
                                    <button type="button" onclick="confirmCancel(this)" class="bg-white dark:bg-gray-800 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 border border-gray-200 dark:border-gray-700 hover:border-rose-300 dark:hover:border-rose-800 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                                        <i class="fa-solid fa-ban"></i> Batal
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="md:hidden space-y-4">
            <?php foreach($bookings as $b): ?>
            <div class="bg-white dark:bg-gray-900 shadow-md border border-gray-100 dark:border-gray-800 rounded-2xl p-5 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 <?= $b['status'] == 'approved' ? 'bg-emerald-500' : ($b['status'] == 'rejected' ? 'bg-rose-500' : 'bg-amber-500') ?>"></div>
                
                <div class="pl-2">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white leading-tight pr-2">
                            <?= esc($b['title']); ?>
                        </h3>
                        <?php if($b['status'] == 'pending'): ?>
                            <span class="shrink-0 bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                Menunggu
                            </span>
                        <?php elseif($b['status'] == 'approved'): ?>
                            <span class="shrink-0 bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                Disetujui
                            </span>
                        <?php elseif($b['status'] == 'rejected'): ?>
                            <span class="shrink-0 bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide">
                                Ditolak
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1 mb-5">
                        <p><i class="fa-regular fa-calendar w-4 text-center"></i> <?= esc($b['date']); ?></p>
                        <p><i class="fa-solid fa-location-dot w-4 text-center text-blue-500"></i> <?= esc($b['location']); ?></p>
                    </div>

                    <div class="flex flex-col gap-2 border-t border-gray-100 dark:border-gray-800 pt-4 mt-2">
                        <?php if($b['status'] == 'approved'): ?>
                            <a href="/ticket/<?= $b['id'] ?>" target="_blank" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition shadow-sm flex justify-center items-center gap-2">
                                <i class="fa-solid fa-download"></i> Unduh Tiket
                            </a>
                        <?php else: ?>
                            <button class="w-full text-center bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-xl text-sm font-bold cursor-not-allowed flex justify-center items-center gap-2" disabled>
                                <i class="fa-solid fa-lock"></i> Tiket Terkunci
                            </button>
                        <?php endif; ?>

                        <?php if($b['status'] == 'pending'): ?>
                        <form action="/booking/delete/<?= $b['id']; ?>" method="post" class="w-full m-0 p-0">
                            <?= csrf_field(); ?>
                            <button type="button" onclick="confirmCancel(this)" class="w-full bg-white dark:bg-gray-800 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-xl text-sm font-bold transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-ban"></i> Batalkan Pesanan
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<?= view('layout/footer'); ?>

<script>
function confirmCancel(button) {
    const form = button.closest('form');
    Swal.fire({
        title: 'Batalkan Tiket?',
        text: 'Pengajuan booking tiket ini akan ditarik kembali.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fa-solid fa-ban mr-2"></i> Ya, Batalkan!',
        cancelButtonText: 'Tutup',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
        customClass: {
            confirmButton: 'rounded-xl',
            cancelButton: 'rounded-xl'
        }
    }).then((result) => {
        if(result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

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