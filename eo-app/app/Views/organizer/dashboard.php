<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analytics</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 space-y-8">

    <div>
        <h1 class="text-3xl md:text-4xl font-bold mb-2 text-gray-800 dark:text-white">
            Welcome Back, <?= esc(session()->get('name')); ?> 👋
        </h1>
        <p class="text-gray-500 dark:text-gray-400">
            Monitor dan kelola performa aktivitas statistik manajemen event secara real-time.
        </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Total Events</p>
                <h2 class="text-2xl md:text-4xl font-black text-indigo-500 mt-1"><?= $totalEvents; ?></h2>
            </div>
            <div class="text-3xl md:text-4xl bg-indigo-50 dark:bg-indigo-950/40 p-3 rounded-xl">📅</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Total Bookings</p>
                <h2 class="text-2xl md:text-4xl font-black text-blue-500 mt-1"><?= $totalBookings; ?></h2>
            </div>
            <div class="text-3xl md:text-4xl bg-blue-50 dark:bg-blue-950/40 p-3 rounded-xl">🎟</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Approved</p>
                <h2 class="text-2xl md:text-4xl font-black text-green-500 mt-1"><?= $totalApproved; ?></h2>
            </div>
            <div class="text-3xl md:text-4xl bg-green-50 dark:bg-green-950/40 p-3 rounded-xl">✅</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Rejected</p>
                <h2 class="text-2xl md:text-4xl font-black text-red-500 mt-1"><?= $totalRejected; ?></h2>
            </div>
            <div class="text-3xl md:text-4xl bg-red-50 dark:bg-red-950/40 p-3 rounded-xl">❌</div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">Upcoming Events</h2>
            <a href="/my-events" class="text-blue-500 hover:text-blue-700 font-medium text-sm">View All</a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <?php if(!empty($upcoming)): ?>
                <?php foreach($upcoming as $u): ?>
                    <div class="border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40 rounded-xl overflow-hidden hover:shadow-md transition">
                        <?php if($u['image']): ?>
                            <img src="/uploads/<?= $u['image']; ?>" class="w-full h-40 object-cover">
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-white"><?= esc($u['title']); ?></h3>
                            <p class="text-gray-500 text-sm mb-1">📍 <?= esc($u['location']); ?></p>
                            <p class="text-gray-500 text-sm">📅 <?= esc($u['date']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-400 dark:text-gray-500 text-sm py-4">Belum ada booking event mendatang.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Booking Analytics (Monthly)</h2>
            <div class="w-full h-full min-h-[300px]">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Booking Status Analytics</h2>
            <div class="max-w-[260px] mx-auto w-full flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// INITIALIZATION: GRAPHIC MONTHLY DATA
const ctx = document.getElementById('bookingChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $chartLabels; ?>, // Langsung cetak variabel string JSON matang dari controller
        datasets: [{
            label: 'Total Booking',
            data: <?= $chartData; ?>, // Langsung cetak variabel string JSON matang dari controller
            backgroundColor: 'rgba(59, 130, 246, 0.8)',
            borderColor: 'rgb(59, 130, 246)',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// INITIALIZATION: GRAPHIC STATUS DATA
const statusCtx = document.getElementById('statusChart');
new Chart(statusCtx, {
    type: 'doughnut', // Mengubah 'pie' menjadi 'doughnut' agar visual lingkaran lebih modern
    data: {
        labels: <?= $statusLabels; ?>,
        datasets: [{
            data: <?= $statusData; ?>,
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',  // Approved (Hijau)
                'rgba(239, 68, 68, 0.8)',  // Rejected (Merah)
                'rgba(249, 115, 22, 0.8)'   // Pending (Oranye)
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
</script>



</body>
</html>