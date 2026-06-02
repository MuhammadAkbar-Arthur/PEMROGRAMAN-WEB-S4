<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manage Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 min-h-screen">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                🎟️ Manage Bookings
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Kelola persetujuan tiket peserta untuk event Anda
            </p>
        </div>
    </div>

    <?php if(empty($bookings)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-10 text-center">
            <div class="text-6xl mb-4">📭</div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Belum Ada Pemesanan
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                Data peserta yang mendaftar ke event Anda akan muncul di sini.
            </p>
        </div>
    <?php else: ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">
                    <tr>
                        <th class="p-5">Peserta</th>
                        <th class="p-5">Event</th>
                        <th class="p-5">Date</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                    <?php foreach($bookings as $booking): ?>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition duration-150">
                        
                        <td class="p-5">
                            <p class="font-bold text-gray-900 dark:text-white"><?= esc($booking['name']); ?></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?= esc($booking['email']); ?></p>
                        </td>

                        <td class="p-5 font-semibold text-gray-900 dark:text-white">
                            <?= esc($booking['title']); ?>
                        </td>

                        <td class="p-5 text-sm">
                            📅 <?= esc($booking['date']); ?>
                        </td>

                        <td class="p-5">
                            <?php if($booking['status'] == 'pending'): ?>
                                <span class="inline-flex items-center bg-amber-100 text-amber-700 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                    Pending
                                </span>
                            <?php elseif($booking['status'] == 'approved'): ?>
                                <span class="inline-flex items-center bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                    Approved
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                    Rejected
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="p-5">
                            <div class="flex gap-2 items-center justify-end">
                                <?php if($booking['status'] == 'pending'): ?>
                                    <a href="/booking/approve/<?= $booking['id']; ?>" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                        Approve
                                    </a>
                                    <a href="/booking/reject/<?= $booking['id']; ?>" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200 dark:border-rose-900 dark:bg-rose-950/30 dark:text-rose-400 px-4 py-2 rounded-lg text-sm font-medium transition">
                                        Reject
                                    </a>
                                <?php else: ?>
                                    <span class="text-sm font-medium text-gray-400 dark:text-gray-500 italic">
                                        Action Done
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<?= view('layout/footer'); ?>

</body>
</html>