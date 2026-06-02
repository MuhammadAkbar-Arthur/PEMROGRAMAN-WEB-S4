<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 max-w-7xl">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                Admin Dashboard 📊
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Monitor statistik event, booking, dan aktivitas pengguna sistem.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="/admin/export" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl shadow transition font-medium text-sm flex items-center gap-2">
                📥 Export CSV Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Users</p>
                    <h2 class="text-4xl font-bold mt-2 text-blue-600 dark:text-blue-400"><?= esc($totalUsers); ?></h2>
                </div>
                <div class="text-4xl bg-blue-50 dark:bg-blue-950/40 p-3 rounded-xl">👤</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Events</p>
                    <h2 class="text-4xl font-bold mt-2 text-purple-600 dark:text-purple-400"><?= esc($totalEvents); ?></h2>
                </div>
                <div class="text-4xl bg-purple-50 dark:bg-purple-950/40 p-3 rounded-xl">🎫</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Bookings</p>
                    <h2 class="text-4xl font-bold mt-2 text-green-600 dark:text-green-400"><?= esc($totalBookings); ?></h2>
                </div>
                <div class="text-4xl bg-green-50 dark:bg-green-950/40 p-3 rounded-xl">📅</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Wishlist</p>
                    <h2 class="text-4xl font-bold mt-2 text-pink-600 dark:text-pink-400"><?= esc($totalFavorites); ?></h2>
                </div>
                <div class="text-4xl bg-pink-50 dark:bg-pink-950/40 p-3 rounded-xl">❤️</div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Booking Analytics</h2>
            <p class="text-sm text-gray-400">Grafik perbandingan total kuota pemesanan tiket per pagelaran event</p>
        </div>
        <div class="relative h-80">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 overflow-x-auto">
            <div class="mb-5">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Moderasi Konten Event Global 🛡️</h2>
                <p class="text-sm text-gray-400">Daftar seluruh event sistem. Admin berhak menghapus event yang melanggar ketentuan.</p>
            </div>
            <table id="eventAdminTable" class="display w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <th>Judul Event</th>
                        <th>Organizer/Owner</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th>Kuota Kontestan</th>
                        <th>Aksi Pembersihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($all_events as $ev): ?>
                        <tr>
                            <td class="font-medium text-gray-900 dark:text-white"><?= esc($ev['title']); ?></td>
                            <td><?= $ev['organizer_name'] ? esc($ev['organizer_name']) : '<span class="text-xs italic text-gray-400">Unknown</span>'; ?></td>
                            <td><?= esc($ev['date']); ?></td>
                            <td><?= esc($ev['location']); ?></td>
                            <td><?= esc($ev['quota']); ?> Slot</td>
                            <td>
                                
                                <a href="/admin/events/delete/<?= $ev['id']; ?>" 
                                    id="btn-delete-<?= $ev['id']; ?>" 
                                    class="delete-force-btn inline-flex bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/20 dark:text-red-400 dark:border-red-950 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                     Hapus Paksa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 overflow-x-auto">
            <div class="mb-5">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recent Booking Activity 📅</h2>
                <p class="text-sm text-gray-400">Log riwayat transaksi pendaftaran tiket masuk terbaru dari para peserta user</p>
            </div>
            <table id="bookingTable" class="display w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <th>User Peserta</th>
                        <th>Nama Event</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Lokasi Tempat</th>
                        <th>Waktu Booking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                        <tr>
                            <td class="font-medium text-gray-900 dark:text-white"><?= $b['user_name']; ?></td>
                            <td><?= esc($b['event_title']); ?></td>
                            <td><?= esc($b['date']); ?></td>
                            <td><?= esc($b['location']); ?></td>
                            <td class="text-gray-400 font-mono text-xs"><?= esc($b['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // 1. Inisialisasi Chart
    const ctx = document.getElementById('bookingChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(json_decode($chartLabels)); ?>,
                datasets: [{
                    label: 'Akumulasi Pendaftar',
                    data: <?= json_encode(json_decode($chartTotals)); ?>,
                    backgroundColor: 'rgba(99, 102, 241, 0.15)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
            }
        });
    }

    // 2. Inisialisasi DataTables
    $('#bookingTable, #eventAdminTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25]
    });

    // 3. Logic Hapus Paksa
    $('body').on('click', '.delete-force-btn', function(e) {
        e.preventDefault(); 
        const url = $(this).attr('href');

        Swal.fire({
            title: 'Yakin?',
            text: "Data event ini akan dihapus permanen! Seluruh data booking akan ikut terhapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
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
Swal.fire({ icon: 'success', title: 'Berhasil 🎉', text: '<?= session()->getFlashdata('success'); ?>', confirmButtonColor: '#2563eb' });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
Swal.fire({ icon: 'error', title: 'Oops 😢', text: '<?= session()->getFlashdata('error'); ?>', confirmButtonColor: '#dc2626' });
</script>
<?php endif; ?>

</body>
</html>