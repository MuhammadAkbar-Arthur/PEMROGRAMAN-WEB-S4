<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Organizer - Elevate</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition duration-300 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12 space-y-8">

    <!-- HEADER GREETING -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold mb-2 text-gray-900 dark:text-white tracking-tight">
                Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400"><?= esc(session()->get('name')); ?>!</span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium">
                Monitor dan kelola performa aktivitas statistik manajemen acara secara real-time.
            </p>
        </div>
        <a href="/event/create" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1 flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-plus"></i> Buat Acara Baru
        </a>
    </div>

    <!-- STATISTIK UTAMA (4 KARTU) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <!-- Total Events -->
        <div class="bg-white dark:bg-gray-900 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 transition-all flex items-center justify-between group">
            <div>
                <p class="text-gray-500 text-xs md:text-sm dark:text-gray-400 font-bold uppercase tracking-wider mb-1">Total Acara</p>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white"><?= $totalEvents; ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white dark:bg-gray-900 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 transition-all flex items-center justify-between group">
            <div>
                <p class="text-gray-500 text-xs md:text-sm dark:text-gray-400 font-bold uppercase tracking-wider mb-1">Total Tiket</p>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white"><?= $totalBookings; ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white dark:bg-gray-900 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 transition-all flex items-center justify-between group">
            <div>
                <p class="text-gray-500 text-xs md:text-sm dark:text-gray-400 font-bold uppercase tracking-wider mb-1">Disetujui</p>
                <h2 class="text-3xl md:text-4xl font-black text-emerald-500"><?= $totalApproved; ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-white dark:bg-gray-900 shadow-sm hover:shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 transition-all flex items-center justify-between group">
            <div>
                <p class="text-gray-500 text-xs md:text-sm dark:text-gray-400 font-bold uppercase tracking-wider mb-1">Ditolak</p>
                <h2 class="text-3xl md:text-4xl font-black text-rose-500"><?= $totalRejected; ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>
    </div>

    <!-- AREA GRAFIK (CHART.JS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Bar Chart: Booking Bulanan -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 shadow-sm rounded-3xl p-6 md:p-8 border border-gray-100 dark:border-gray-800 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-blue-500"></i> Analitik Pemesanan
                </h2>
            </div>
            <div class="w-full flex-grow min-h-[300px] relative">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart: Status Pemesanan -->
        <div class="bg-white dark:bg-gray-900 shadow-sm rounded-3xl p-6 md:p-8 border border-gray-100 dark:border-gray-800 flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-purple-500"></i> Rasio Status
                </h2>
            </div>
            <div class="w-full flex-grow flex items-center justify-center min-h-[300px]">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

    </div>

    <!-- ACARA MENDATANG -->
    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-3xl p-6 md:p-8 border border-gray-100 dark:border-gray-800">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-regular fa-calendar-check text-blue-500"></i> Acara Mendatang Anda
            </h2>
            <a href="/organizer/my-events" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-bold text-sm flex items-center gap-1 transition">
                Lihat Semua <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php if(!empty($upcoming)): ?>
                <?php foreach($upcoming as $u): ?>
                    <div class="group border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                        <div class="relative overflow-hidden aspect-[16/9]">
                            <?php if($u['image']): ?>
                                <img src="/uploads/<?= esc($u['image'], 'url'); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <?php else: ?>
                                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-full object-cover filter grayscale-[30%] group-hover:scale-110 transition duration-500">
                            <?php endif; ?>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold text-lg mb-3 text-gray-900 dark:text-white line-clamp-2 leading-tight">
                                <?= esc($u['title']); ?>
                            </h3>
                            <div class="mt-auto space-y-2">
                                <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2 font-medium">
                                    <i class="fa-solid fa-location-dot w-4 text-center text-rose-500"></i> <span class="truncate"><?= esc($u['location']); ?></span>
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2 font-medium">
                                    <i class="fa-regular fa-calendar w-4 text-center text-blue-500"></i> <?= esc($u['date']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-gray-50 dark:bg-gray-800/20 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                    <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada acara mendatang yang Anda kelola.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if(session()->getFlashdata('success')): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: <?= json_encode(session()->getFlashdata('success')); ?>,
    showConfirmButton: false,
    timer: 3000,
    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
});
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: <?= json_encode(session()->getFlashdata('error')); ?>,
    showConfirmButton: false,
    timer: 3000,
    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
});
</script>
<?php endif; ?>

<!-- SCRIPT CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ambil variabel CSS untuk deteksi mode gelap agar teks chart terbaca
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9ca3af' : '#4b5563';
    const gridColor = isDarkMode ? '#374151' : '#f3f4f6';

    // 1. GRAFIK BAR (BOOKING BULANAN)
    const ctx = document.getElementById('bookingChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $chartLabels; ?>,
            datasets: [{
                label: 'Total Tiket Terjual',
                data: <?= $chartData; ?>,
                backgroundColor: 'rgba(37, 99, 235, 0.8)', // Blue-600
                hoverBackgroundColor: 'rgba(29, 78, 216, 1)', // Blue-700
                borderRadius: 6,
                borderSkipped: false,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDarkMode ? '#1f2937' : '#ffffff',
                    titleColor: isDarkMode ? '#f9fafb' : '#111827',
                    bodyColor: isDarkMode ? '#f9fafb' : '#4b5563',
                    borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 4
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: textColor },
                    grid: { color: gridColor, drawBorder: false }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });

    // 2. GRAFIK DOUGHNUT (RASIO STATUS)
    const statusCtx = document.getElementById('statusChart');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: <?= $statusLabels; ?>,
            datasets: [{
                data: <?= $statusData; ?>,
                backgroundColor: [
                    'rgba(16, 185, 129, 0.9)',  // Emerald (Approved)
                    'rgba(244, 63, 94, 0.9)',   // Rose (Rejected)
                    'rgba(245, 158, 11, 0.9)'   // Amber (Pending)
                ],
                borderWidth: 4,
                borderColor: isDarkMode ? '#111827' : '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: textColor, padding: 20, usePointStyle: true, pointStyle: 'circle' }
                }
            }
        }
    });
</script>

</body>
</html>