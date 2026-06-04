<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Elevate</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <style>
        /* =========================================================
           CUSTOM DATATABLES UNTUK TAILWIND & DARK MODE 
           ========================================================= */
        table.dataTable { border-collapse: collapse !important; width: 100% !important; margin-top: 15px !important; margin-bottom: 15px !important; }
        table.dataTable thead th { border-bottom: 2px solid #e5e7eb !important; padding: 12px 10px !important; font-size: 13px; text-transform: uppercase; color: #6b7280; }
        table.dataTable tbody td { border-bottom: 1px solid #f3f4f6 !important; padding: 12px 10px !important; vertical-align: middle; }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db !important; border-radius: 8px !important; padding: 6px 12px !important; background-color: #f9fafb !important; outline: none !important; transition: border 0.3s;
        }
        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 8px !important; border: 1px solid transparent !important; margin: 0 2px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #3b82f6 !important; color: white !important; border-color: #3b82f6 !important; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2) !important; }
        
        /* Dark Mode Overrides */
        .dark table.dataTable thead th { border-bottom-color: #374151 !important; color: #9ca3af !important; }
        .dark table.dataTable tbody td { border-bottom-color: #1f2937 !important; color: #d1d5db !important; }
        .dark .dataTables_wrapper .dataTables_length select,
        .dark .dataTables_wrapper .dataTables_filter input { border-color: #4b5563 !important; background-color: #111827 !important; color: white !important; }
        .dark .dataTables_wrapper .dataTables_info { color: #9ca3af !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button { color: #9ca3af !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current):hover { background: #374151 !important; border-color: #4b5563 !important; color: white !important; }
        .dark table.dataTable tbody tr { background-color: transparent !important; }
        .dark table.dataTable tbody tr:hover { background-color: rgba(31, 41, 55, 0.5) !important; }
        .dark .dataTables_empty { color: #9ca3af !important; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-700 to-slate-900 dark:from-slate-200 dark:to-slate-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-screwdriver-wrench text-slate-800 dark:text-slate-300"></i> Admin Dashboard
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Pusat kendali sistem. Monitor statistik acara, pemesanan, dan moderasi konten.
            </p>
        </div>
        <a href="/admin/export" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition transform hover:-translate-y-1 flex items-center gap-2 shrink-0">
            <i class="fa-solid fa-file-csv"></i> Ekspor Data CSV
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-2xl p-6 flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pengguna</p>
                <h2 class="text-4xl font-black text-blue-600 dark:text-blue-400"><?= esc($totalUsers); ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-2xl p-6 flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Acara</p>
                <h2 class="text-4xl font-black text-purple-600 dark:text-purple-400"><?= esc($totalEvents); ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-ticket"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-2xl p-6 flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Tiket Terjual</p>
                <h2 class="text-4xl font-black text-emerald-600 dark:text-emerald-400"><?= esc($totalBookings); ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-2xl p-6 flex justify-between items-center group hover:shadow-md transition">
            <div>
                <p class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Wishlist</p>
                <h2 class="text-4xl font-black text-pink-600 dark:text-pink-400"><?= esc($totalFavorites); ?></h2>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-pink-50 dark:bg-pink-900/30 text-pink-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-heart"></i>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-chart-area text-blue-500"></i> Analitik Lalu Lintas Pemesanan
            </h2>
        </div>
        <div class="relative w-full h-80">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 overflow-hidden">
            <div class="mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-rose-500"></i> Moderasi Konten Acara Global
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar seluruh acara sistem. Hapus secara paksa jika acara melanggar standar komunitas.</p>
            </div>
            <div class="overflow-x-auto">
                <table id="eventAdminTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>Judul Acara</th>
                            <th>Penyelenggara (Owner)</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Kapasitas</th>
                            <th class="text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_events as $ev): ?>
                            <tr>
                                <td class="font-bold text-gray-900 dark:text-white whitespace-nowrap"><?= esc($ev['title']); ?></td>
                                <td class="whitespace-nowrap">
                                    <?= $ev['organizer_name'] ? '<span class="font-medium">'.esc($ev['organizer_name']).'</span>' : '<span class="text-xs italic text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">Tidak Diketahui</span>'; ?>
                                </td>
                                <td class="whitespace-nowrap"><?= esc($ev['date']); ?></td>
                                <td class="whitespace-nowrap"><?= esc($ev['location']); ?></td>
                                <td class="whitespace-nowrap"><?= esc($ev['quota']); ?> Slot</td>
                                <td class="text-right whitespace-nowrap">
                                    <a href="/admin/events/delete/<?= $ev['id']; ?>" class="delete-force-btn inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-500 hover:text-white text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white border border-rose-200 dark:border-rose-900/50 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fa-solid fa-gavel"></i> Hapus Paksa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 overflow-hidden">
            <div class="mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-emerald-500"></i> Riwayat Transaksi Terbaru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Log (rekaman) aktivitas pendaftaran tiket masuk yang baru saja dilakukan oleh pengguna.</p>
            </div>
            <div class="overflow-x-auto">
                <table id="bookingTable" class="display w-full">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Acara Tujuan</th>
                            <th>Tanggal Acara</th>
                            <th>Lokasi</th>
                            <th>Waktu Rekam (Log)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($bookings as $b): ?>
                            <tr>
                                <td class="font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                    <i class="fa-regular fa-circle-user text-gray-400 mr-1"></i> <?= esc($b['user_name']); ?>
                                </td>
                                <td class="whitespace-nowrap font-medium"><?= esc($b['event_title']); ?></td>
                                <td class="whitespace-nowrap"><?= esc($b['date']); ?></td>
                                <td class="whitespace-nowrap"><?= esc($b['location']); ?></td>
                                <td class="text-gray-500 dark:text-gray-400 font-mono text-xs whitespace-nowrap">
                                    <?= esc($b['created_at']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    const isDarkMode = document.documentElement.classList.contains('dark');
    const textColor = isDarkMode ? '#9ca3af' : '#4b5563';
    const gridColor = isDarkMode ? '#374151' : '#f3f4f6';

    // 1. Inisialisasi Chart (Bar)
    const ctx = document.getElementById('bookingChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(json_decode($chartLabels)); ?>,
                datasets: [{
                    label: 'Total Pendaftar',
                    data: <?= json_encode(json_decode($chartTotals)); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.8)', // Indigo-500
                    hoverBackgroundColor: 'rgba(79, 70, 229, 1)', // Indigo-600
                    borderSkipped: false,
                    borderRadius: 6,
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
                        padding: 12
                    }
                },
                scales: { 
                    y: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, ticks: { color: textColor, stepSize: 1 } }, 
                    x: { grid: { display: false }, ticks: { color: textColor } } 
                }
            }
        });
    }

    // 2. Inisialisasi DataTables
    $('#bookingTable, #eventAdminTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Maju",
                previous: "Mundur"
            }
        }
    });

    // 3. Logic Hapus Paksa
    $('body').on('click', '.delete-force-btn', function(e) {
        e.preventDefault(); 
        const url = $(this).attr('href');

        Swal.fire({
            title: 'Tindak Tegas?',
            text: "Acara ini akan dihapus secara paksa dari sistem! Seluruh tiket dan transaksi terkait akan ikut terhapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626', // Rose
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-gavel mr-2"></i> Ya, Hapus Paksa!',
            cancelButtonText: 'Batal',
            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
            customClass: { confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
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