<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-950 transition duration-300 text-slate-800 dark:text-slate-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 max-w-7xl">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Kelola User 👥
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">
            Manage role, akses, dan moderasi akun pengguna sistem
        </p>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-400 px-4 py-3 rounded-xl mb-5">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-rose-100 border border-rose-200 text-rose-700 dark:bg-rose-900/30 dark:border-rose-800 dark:text-rose-400 px-4 py-3 rounded-xl mb-5">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">

        <div class="block md:hidden divide-y divide-slate-200 dark:divide-slate-800">
            <?php foreach($users as $u): ?>
                <div class="p-4 flex flex-col gap-4">
                    <div class="flex justify-between items-start gap-4">
                        <div class="min-w-0">
                            <h2 class="font-semibold text-slate-800 dark:text-white text-base truncate">
                                <?= esc($u['name']); ?>
                            </h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400 break-all">
                                <?= esc($u['email']); ?>
                            </p>
                        </div>

                        <?php if($u['role'] == 'admin'): ?>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 dark:bg-red-950/40 dark:text-red-400 dark:border-red-900">
                                Admin
                            </span>
                        <?php elseif($u['role'] == 'organizer'): ?>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-900">
                                Organizer
                            </span>
                        <?php else: ?>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                                User
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if($u['id'] != session()->get('id')): ?>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                            <?php if($u['role'] == 'user'): ?>
                                <a href="/admin/users/make-organizer/<?= $u['id']; ?>"
                                class="w-full inline-flex justify-center items-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-2.5 rounded-xl text-sm font-medium transition dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900">
                                    Jadikan Organizer
                                </a>
                            <?php endif; ?>

                            <?php if($u['role'] == 'organizer'): ?>
                                <a href="/admin/users/make-user/<?= $u['id']; ?>"
                                class="w-full inline-flex justify-center items-center bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 px-4 py-2.5 rounded-xl text-sm font-medium transition dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900">
                                    Jadikan User
                                </a>
                            <?php endif; ?>

                            <a href="/admin/users/delete/<?= $u['id']; ?>"
                               onclick="return confirm('PERINGATAN! Menghapus user ini akan menghapus semua event & tiket booking terkait secara permanen. Lanjutkan?')"
                               class="w-full inline-flex justify-center items-center bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-4 py-2.5 rounded-xl text-sm font-medium transition dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900">
                                Hapus Akun
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-700 text-xs uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <?php foreach($users as $u): ?>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition">
                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">
                                <?= esc($u['name']); ?>
                            </td>

                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400 max-w-[220px] truncate">
                                <?= esc($u['email']); ?>
                            </td>

                            <td class="px-6 py-4">
                                <?php if($u['role'] == 'admin'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200 dark:bg-red-950/40 dark:text-red-400 dark:border-red-900">
                                        Admin
                                    </span>
                                <?php elseif($u['role'] == 'organizer'): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-900">
                                        Organizer
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                                        User
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <?php if($u['id'] != session()->get('id')): ?>
                                    <?php if($u['role'] == 'user'): ?>
                                        <a href="/admin/users/make-organizer/<?= $u['id']; ?>"
                                        class="inline-flex items-center bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-4 py-2 rounded-xl text-sm font-medium transition dark:bg-emerald-950/20 dark:text-emerald-400 dark:border-emerald-900">
                                            Jadikan Organizer
                                        </a>
                                    <?php endif; ?>

                                    <?php if($u['role'] == 'organizer'): ?>
                                        <a href="/admin/users/make-user/<?= $u['id']; ?>"
                                        class="inline-flex items-center bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 px-4 py-2 rounded-xl text-sm font-medium transition dark:bg-amber-950/20 dark:text-amber-400 dark:border-amber-900">
                                            Jadikan User
                                        </a>
                                    <?php endif; ?>

                                    <a href="/admin/users/delete/<?= $u['id']; ?>"
                                       onclick="return confirm('PERINGATAN! Menghapus user ini akan menghapus semua event & tiket booking terkait secara permanen. Lanjutkan?')"
                                       class="inline-flex items-center bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 dark:bg-rose-950/20 dark:text-rose-400 dark:border-rose-900 px-4 py-2 rounded-xl text-sm font-medium transition">
                                        Hapus
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs italic text-slate-400 py-2">Sesi Anda</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>