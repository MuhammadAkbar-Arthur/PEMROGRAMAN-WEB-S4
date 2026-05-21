<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analytics - Event Organizer</title>

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
            <div class="text-3xl bg-indigo-50 dark:bg-indigo-950/40 p-3 rounded-xl">📅</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Total Bookings</p>
                <h2 class="text-2xl md:text-4xl font-black text-blue-500 mt-1"><?= $totalBookings; ?></h2>
            </div>
            <div class="text-3xl bg-blue-50 dark:bg-blue-950/40 p-3 rounded-xl">🎟</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Approved</p>
                <h2 class="text-2xl md:text-4xl font-black text-green-500 mt-1"><?= $totalApproved; ?></h2>
            </div>
            <div class="text-3xl bg-green-50 dark:bg-green-950/40 p-3 rounded-xl">✅</div>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-5 flex items-center justify-between border border-gray-100 dark:border-gray-800">
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-400 font-medium">Rejected</p>
                <h2 class="text-2xl md:text-4xl font-black text-red-500 mt-1"><?= $totalRejected; ?></h2>
            </div>
            <div class="text-3xl bg-red-50 dark:bg-red-950/40 p-3 rounded-xl">❌</div>
        </div>
    </div>

    <?php if(session()->get('role') == 'user'): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Upcoming Events</h2>
                    <a href="/my-bookings" class="text-blue-500 hover:text-blue-700 font-medium text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    <?php if(!empty($upcoming)): ?>
                        <?php foreach($upcoming as $u): ?>
                            <div class="border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl flex gap-4 items-center">
                                <?php if($u['image']): ?>
                                    <img src="/uploads/<?= $u['image']; ?>" class="w-16 h-16 object-cover rounded-lg">
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-bold text-base text-gray-800 dark:text-white"><?= esc($u['title']); ?></h3>
                                    <p class="text-gray-500 text-xs mt-1">📍 <?= esc($u['location']); ?> | 📅 <?= esc($u['date']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-400 text-sm py-4">Belum ada booking event mendatang.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Recent Wishlist</h2>
                    <a href="/favorite" class="text-pink-500 hover:text-pink-700 font-medium text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    <?php if(!empty($favorites)): ?>
                        <?php foreach($favorites as $f): ?>
                            <div class="border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/40 p-4 rounded-xl flex gap-4 items-center">
                                <?php if($f['image']): ?>
                                    <img src="/uploads/<?= $f['image']; ?>" class="w-16 h-16 object-cover rounded-lg">
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-bold text-base text-gray-800 dark:text-white"><?= esc($f['title']); ?></h3>
                                    <p class="text-gray-500 text-xs mt-1">📍 <?= esc($f['location']); ?> | 📅 <?= esc($f['date']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-400 text-sm py-4">Wishlist kamu masih kosong.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session()->get('role') != 'user'): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 min-h-[340px]">
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Booking Analytics (Monthly)</h2>
                <div class="w-full h-64">
                    <canvas id="bookingChart"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Booking Status Analytics</h2>
                <div class="max-w-[220px] mx-auto w-full flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
                <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Top Event Performance 🔥</h2>
                <div class="space-y-4">
                    <?php foreach($topEvents as $event): ?>
                        <div class="flex items-center justify-between border border-gray-100 dark:border-gray-800 p-3 rounded-xl bg-gray-50 dark:bg-gray-800/20">
                            <div class="flex items-center gap-3">
                                <?php if($event['image']): ?>
                                    <img src="/uploads/<?= $event['image']; ?>" class="w-12 h-12 rounded-lg object-cover">
                                <?php endif; ?>
                                <div>
                                    <h3 class="font-bold text-sm text-gray-800 dark:text-white"><?= esc($event['title']); ?></h3>
                                    <p class="text-gray-400 text-xs mt-0.5">Total Booking: <span class="text-blue-500 font-bold"><?= $event['total_booking']; ?></span></p>
                                </div>
                            </div>
                            <div class="text-xl">🏆</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="md:col-span-2 bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 overflow-x-auto">
                <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Latest Bookings 🎟</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 text-gray-400 text-left">
                            <th class="pb-3 font-semibold">User</th>
                            <th class="pb-3 font-semibold">Event</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                        <?php foreach($latestBookings as $booking): ?>
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td class="py-3 font-medium"><?= esc($booking['user_name']); ?></td>
                                <td class="py-3 text-gray-500"><?= esc($booking['event_title']); ?></td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-md text-xs font-bold 
                                        <?= $booking['status'] == 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($booking['status'] == 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400') ?>">
                                        <?= ucfirst(esc($booking['status'])); ?>
                                    </span>
                                </td>
                                <td class="py-3 text-xs text-gray-400"><?= esc($booking['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if(session()->get('role') == 'admin'): ?>
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 border border-gray-100 dark:border-gray-800 overflow-x-auto">
                <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Latest Registered Users 👤</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 text-gray-400 text-left">
                            <th class="pb-3 font-semibold">Name</th>
                            <th class="pb-3 font-semibold">Email</th>
                            <th class="pb-3 font-semibold">Role</th>
                            <th class="pb-3 font-semibold">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                        <?php foreach($latestUsers as $user): ?>
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td class="py-3 font-medium"><?= esc($user['name']); ?></td>
                                <td class="py-3 text-gray-500"><?= esc($user['email']); ?></td>
                                <td class="py-3"><span class="bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded text-xs"><?= esc($user['role']); ?></span></td>
                                <td class="py-3 text-xs text-gray-400"><?= esc($user['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<?php if(session()->get('role') != 'user'): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // 1. MONTHLY BOOKING ANALYTICS
    const ctx = document.getElementById('bookingChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $chartLabels; ?>, // Pemanggilan aman tanpa double json_encode()
            datasets: [{
                label: 'Total Booking',
                data: <?= $chartData; ?>, // Pemanggilan aman tanpa double json_encode()
                backgroundColor: 'rgba(59, 130, 246, 0.85)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // 2. STATUS ANALYTICS (DOUGHNUT STYLE)
    const statusCtx = document.getElementById('statusChart');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: <?= $statusLabels; ?>, // Pemanggilan aman tanpa double json_encode()
            datasets: [{
                data: <?= $statusData; ?>, // Pemanggilan aman tanpa double json_encode()
                backgroundColor: [
                    'rgba(34, 197, 94, 0.85)',  // Approved -> Hijau
                    'rgba(239, 68, 68, 0.85)',  // Rejected -> Merah
                    'rgba(249, 115, 22, 0.85)'   // Pending -> Oranye
                ],
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });
    </script>
<?php endif; ?>

</body>
</html>