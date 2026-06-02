<!DOCTYPE html>
<html lang="id">
<head>
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 min-h-screen">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">
                🎫 My Bookings
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Pantau status pendaftaran dan unduh tiket event kamu di sini
            </p>
        </div>
        <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow-md transition font-medium">
            ← Back Home
        </a>
    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($bookings)): ?>
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-10 text-center max-w-2xl mx-auto mt-10">
            <div class="text-6xl mb-4">😢</div>
            <h2 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white">
                Belum ada tiket yang dipesan
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                Yuk temukan dan amankan kursi di event favoritmu sekarang!
            </p>
            <a href="/" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-medium shadow-lg shadow-emerald-500/30 transition transform hover:-translate-y-1">
                Explore Events
            </a>
        </div>
    <?php else: ?>

    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 text-sm uppercase tracking-wider text-gray-500 dark:text-gray-400 font-semibold">
                <tr>
                    <th class="p-5">No</th>
                    <th class="p-5">Event</th>
                    <th class="p-5">Date</th>
                    <th class="p-5">Location</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-800 dark:text-gray-200">
                <?php $no = 1; ?>
                <?php foreach($bookings as $b): ?>
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition duration-150">
                    <td class="p-5 font-mono text-gray-500 dark:text-gray-400">
                        <?= $no++; ?>
                    </td>
                    <td class="p-5 font-bold text-gray-900 dark:text-white">
                        <?= esc($b['title']); ?>
                    </td>
                    <td class="p-5 text-sm">
                        <?= esc($b['date']); ?>
                    </td>
                    <td class="p-5 text-sm">
                        📍 <?= esc($b['location']); ?>
                    </td>
                    <td class="p-5">
                        <?php if($b['status'] == 'pending'): ?>
                            <span class="inline-flex items-center bg-amber-100 text-amber-700 border border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                Pending
                            </span>
                        <?php elseif($b['status'] == 'approved'): ?>
                            <span class="inline-flex items-center bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                Approved
                            </span>
                        <?php elseif($b['status'] == 'rejected'): ?>
                            <span class="inline-flex items-center bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                Rejected
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="p-5">
                        <div class="flex gap-2 items-center justify-end">
                            
                            <!-- TICKET DOWNLOAD BUTTON -->
                            <?php if($b['status'] == 'approved'): ?>
                                <a href="/ticket/<?= $b['id'] ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    Unduh Tiket
                                </a>
                            <?php else: ?>
                                <button class="bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500 dark:border-gray-700 border px-4 py-2 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                    Terkunci
                                </button>
                            <?php endif; ?>

                            <!-- CANCEL BUTTON -->
                            <?php if($b['status'] == 'pending'): ?>
                            <form action="/booking/delete/<?= $b['id']; ?>" method="post" class="inline m-0 p-0">
                                <?= csrf_field(); ?>
                                <button type="button" onclick="confirmCancel(this)" class="bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200 dark:border-rose-900 dark:bg-rose-950/30 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                    Batal
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
    <?php endif; ?>

</div>

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
        cancelButtonColor: '#4b5563',
        confirmButtonText: 'Ya, Batalkan!',
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    }).then((result) => {
        if(result.isConfirmed) {
            form.submit();
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