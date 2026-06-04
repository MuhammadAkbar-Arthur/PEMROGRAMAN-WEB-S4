<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Elevate</title>
    
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
                <i class="fa-solid fa-clipboard-user text-blue-600 dark:text-blue-400"></i> Manajemen Pesanan
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Tinjau dan kelola persetujuan tiket peserta untuk semua acara Anda.
            </p>
        </div>
        <a href="/organizer" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-chart-line"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($bookings)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-3xl p-12 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-6 text-gray-300 dark:text-gray-700">
                <i class="fa-solid fa-inbox"></i>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Belum Ada Pesanan Masuk
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                Data peserta yang mendaftar ke acara Anda akan otomatis muncul di sini. Terus promosikan acara Anda!
            </p>
        </div>
    <?php else: ?>

        <!-- ============================================== -->
        <!-- 1. TAMPILAN DESKTOP (TABEL MODERN)             -->
        <!-- ============================================== -->
        <div class="hidden md:block bg-white dark:bg-gray-900 shadow-xl border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-800 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">
                    <tr>
                        <th class="p-5 w-16 text-center">No</th>
                        <th class="p-5">Peserta</th>
                        <th class="p-5">Acara & Tanggal</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Aksi Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                    <?php $no = 1; ?>
                    <?php foreach($bookings as $booking): ?>
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-gray-800/40 transition duration-200">
                        
                        <td class="p-5 text-center font-bold text-gray-400 dark:text-gray-500">
                            <?= $no++; ?>
                        </td>

                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                                    <?= strtoupper(substr($booking['name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white"><?= esc($booking['name']); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium"><?= esc($booking['email']); ?></p>
                                </div>
                            </div>
                        </td>

                        <td class="p-5">
                            <p class="font-bold text-gray-900 dark:text-white line-clamp-1 mb-1">
                                <?= esc($booking['title']); ?>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                <i class="fa-regular fa-calendar text-blue-500 mr-1"></i> <?= esc($booking['date']); ?>
                            </p>
                        </td>

                        <td class="p-5">
                            <?php if($booking['status'] == 'pending'): ?>
                                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Menunggu
                                </span>
                            <?php elseif($booking['status'] == 'approved'): ?>
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-circle-check"></i> Disetujui
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide">
                                    <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="p-5">
                            <div class="flex gap-2 items-center justify-end">
                                <?php if($booking['status'] == 'pending'): ?>
                                    <!-- Tombol Approve -->
                                    <a href="/booking/approve/<?= $booking['id']; ?>" onclick="confirmApprove(event, this.href)" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition shadow-sm shadow-emerald-500/30 flex items-center gap-2">
                                        <i class="fa-solid fa-check"></i> Setujui
                                    </a>
                                    <!-- Tombol Reject -->
                                    <a href="/booking/reject/<?= $booking['id']; ?>" onclick="confirmReject(event, this.href)" class="bg-white dark:bg-gray-800 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 border border-gray-200 dark:border-gray-700 hover:border-rose-300 dark:hover:border-rose-800 px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </a>
                                <?php else: ?>
                                    <span class="text-sm font-bold text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-xl border border-transparent dark:border-gray-700">
                                        <i class="fa-solid fa-lock mr-1"></i> Selesai
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- ============================================== -->
        <!-- 2. TAMPILAN MOBILE (KARTU RESPONSIVE)          -->
        <!-- ============================================== -->
        <div class="md:hidden space-y-4">
            <?php foreach($bookings as $booking): ?>
            <div class="bg-white dark:bg-gray-900 shadow-md border border-gray-100 dark:border-gray-800 rounded-2xl p-5 relative overflow-hidden">
                
                <!-- Aksen Garis Samping sesuai Status -->
                <div class="absolute left-0 top-0 bottom-0 w-1.5 <?= $booking['status'] == 'approved' ? 'bg-emerald-500' : ($booking['status'] == 'rejected' ? 'bg-rose-500' : 'bg-amber-500') ?>"></div>
                
                <div class="pl-2">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold shrink-0">
                                <?= strtoupper(substr($booking['name'], 0, 1)); ?>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white leading-tight"><?= esc($booking['name']); ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?= esc($booking['email']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800/50 p-3 rounded-xl mb-4 border border-gray-100 dark:border-gray-700/50">
                        <p class="font-bold text-gray-900 dark:text-white text-sm mb-1"><?= esc($booking['title']); ?></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400"><i class="fa-regular fa-calendar mr-1"></i> <?= esc($booking['date']); ?></p>
                    </div>

                    <!-- Tombol Aksi Mobile -->
                    <?php if($booking['status'] == 'pending'): ?>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <a href="/booking/approve/<?= $booking['id']; ?>" onclick="confirmApprove(event, this.href)" class="w-full text-center bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-3 rounded-xl text-sm font-bold transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-check"></i> Setujui
                            </a>
                            <a href="/booking/reject/<?= $booking['id']; ?>" onclick="confirmReject(event, this.href)" class="w-full text-center bg-white dark:bg-gray-800 text-rose-600 border border-gray-200 dark:border-gray-700 hover:bg-rose-50 dark:hover:bg-rose-900/20 px-4 py-3 rounded-xl text-sm font-bold transition flex justify-center items-center gap-2">
                                <i class="fa-solid fa-xmark"></i> Tolak
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="w-full text-center bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-4 py-3 rounded-xl text-sm font-bold border border-transparent dark:border-gray-700">
                            <?= $booking['status'] == 'approved' ? '<i class="fa-solid fa-circle-check text-emerald-500 mr-2"></i> Tiket Disetujui' : '<i class="fa-solid fa-circle-xmark text-rose-500 mr-2"></i> Tiket Ditolak' ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi Setujui (Approve)
    function confirmApprove(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Setujui Pesanan?',
            text: 'Peserta akan mendapatkan akses ke E-Ticket mereka.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // Emerald
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-check mr-2"></i> Ya, Setujui',
            cancelButtonText: 'Batal',
            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
            customClass: { confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // Konfirmasi Tolak (Reject)
    function confirmReject(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Tolak Pesanan?',
            text: 'Peserta tidak akan bisa mengunduh tiket untuk acara ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Rose
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-xmark mr-2"></i> Ya, Tolak',
            cancelButtonText: 'Batal',
            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
            customClass: { confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
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