<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-700 to-slate-900 dark:from-slate-200 dark:to-slate-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-users-gear text-slate-800 dark:text-slate-300"></i> Kelola Pengguna
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Atur hak akses, tingkatkan peran pengguna, atau hapus akun dari sistem.
            </p>
        </div>
        <a href="/admin" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-chart-line"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

        <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-800">
            <?php foreach($users as $u): ?>
                <div class="p-5 flex flex-col gap-4 relative">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold shrink-0">
                                <?= strtoupper(substr($u['name'], 0, 1)); ?>
                            </div>
                            <div class="min-w-0">
                                <h2 class="font-bold text-gray-900 dark:text-white text-base truncate">
                                    <?= esc($u['name']); ?>
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 break-all font-medium">
                                    <?= esc($u['email']); ?>
                                </p>
                            </div>
                        </div>

                        <?php if($u['role'] == 'admin'): ?>
                            <span class="shrink-0 inline-flex items-center gap-1 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50">
                                <i class="fa-solid fa-crown"></i> Admin
                            </span>
                        <?php elseif($u['role'] == 'organizer'): ?>
                            <span class="shrink-0 inline-flex items-center gap-1 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800/50">
                                <i class="fa-solid fa-store"></i> Organizer
                            </span>
                        <?php else: ?>
                            <span class="shrink-0 inline-flex items-center gap-1 px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                                <i class="fa-solid fa-user"></i> User
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($u['id'] != session()->get('id')): ?>
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 flex gap-2">
                            <?php if($u['role'] == 'user'): ?>
                                <a href="/admin/users/make-organizer/<?= $u['id']; ?>" class="flex-1 inline-flex justify-center items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 border border-emerald-200 px-3 py-2.5 rounded-xl text-xs font-bold transition dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50">
                                    <i class="fa-solid fa-arrow-up"></i> Jadikan Organizer
                                </a>
                            <?php endif; ?>

                            <?php if($u['role'] == 'organizer'): ?>
                                <a href="/admin/users/make-user/<?= $u['id']; ?>" class="flex-1 inline-flex justify-center items-center gap-2 bg-amber-50 hover:bg-amber-100 text-amber-600 border border-amber-200 px-3 py-2.5 rounded-xl text-xs font-bold transition dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50">
                                    <i class="fa-solid fa-arrow-down"></i> Jadikan User
                                </a>
                            <?php endif; ?>

                            <a href="/admin/users/delete/<?= $u['id']; ?>" class="delete-user-btn shrink-0 w-10 inline-flex justify-center items-center bg-white dark:bg-gray-800 text-rose-600 border border-gray-200 dark:border-gray-700 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition" title="Hapus Akun">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">
                        <th class="px-6 py-4">Informasi Pengguna</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php foreach($users as $u): ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold">
                                        <?= strtoupper(substr($u['name'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white"><?= esc($u['name']); ?></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium"><?= esc($u['email']); ?></p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <?php if($u['role'] == 'admin'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50">
                                        <i class="fa-solid fa-crown"></i> Admin
                                    </span>
                                <?php elseif($u['role'] == 'organizer'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide bg-blue-50 text-blue-600 border border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800/50">
                                        <i class="fa-solid fa-store"></i> Organizer
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wide bg-gray-100 text-gray-600 border border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                                        <i class="fa-solid fa-user"></i> User
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2 items-center">
                                    <?php if($u['id'] != session()->get('id')): ?>
                                        
                                        <?php if($u['role'] == 'user'): ?>
                                            <a href="/admin/users/make-organizer/<?= $u['id']; ?>" class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-500 hover:text-white text-emerald-600 border border-emerald-200 dark:border-emerald-800/50 px-4 py-2 rounded-xl text-xs font-bold transition dark:bg-emerald-900/20 dark:text-emerald-400 dark:hover:bg-emerald-600 dark:hover:text-white">
                                                <i class="fa-solid fa-arrow-up"></i> Jadikan Organizer
                                            </a>
                                        <?php endif; ?>

                                        <?php if($u['role'] == 'organizer'): ?>
                                            <a href="/admin/users/make-user/<?= $u['id']; ?>" class="inline-flex items-center gap-2 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-600 border border-amber-200 dark:border-amber-800/50 px-4 py-2 rounded-xl text-xs font-bold transition dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white">
                                                <i class="fa-solid fa-arrow-down"></i> Turunkan ke User
                                            </a>
                                        <?php endif; ?>

                                        <a href="/admin/users/delete/<?= $u['id']; ?>" class="delete-user-btn inline-flex items-center bg-white dark:bg-gray-800 text-rose-600 border border-gray-200 dark:border-gray-700 hover:bg-rose-50 dark:hover:bg-rose-900/20 px-4 py-2 rounded-xl text-xs font-bold transition" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>

                                    <?php else: ?>
                                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-xl border border-transparent dark:border-gray-700 flex items-center gap-2">
                                            <i class="fa-solid fa-shield-cat"></i> Sesi Anda
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Logic SweetAlert untuk Hapus User
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 
            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Peringatan Berbahaya!',
                text: "Menghapus user ini akan melenyapkan semua acara & tiket pemesanan yang terkait dengannya secara permanen. Anda yakin?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Rose
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-skull-crossbones mr-2"></i> Ya, Hapus Permanen',
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