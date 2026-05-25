<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 mb-12">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6 md:p-8">

        <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">
            My Profile
        </h1>

        <div class="flex justify-center mb-8">
            <div class="relative">
                <?php if($user['avatar']): ?>
                    <img src="/uploads/<?= esc($user['avatar'], 'url'); ?>"
                         class="w-36 h-36 rounded-full object-cover border-4 border-blue-500 shadow-md">
                <?php else: ?>
                    <div class="w-36 h-36 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-5xl shadow-inner">
                        👤
                    </div>
                <?php endif; ?>
                <div class="absolute bottom-1 right-1 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full border-2 border-white dark:border-gray-900 uppercase">
                    <?= esc(session()->get('role')); ?>
                </div>
            </div>
        </div>

        <form action="/profile/update" method="post" enctype="multipart/form-data">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="<?= esc($user['name']); ?>" 
                           class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" value="<?= esc($user['email']); ?>" 
                           class="w-full border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/50 p-3 rounded-xl text-gray-500 cursor-not-allowed" disabled>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Phone</label>
                    <input type="text" name="phone" value="<?= esc($user['phone']); ?>" 
                           class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Bio</label>
                    <textarea name="bio" rows="4" 
                              class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition"><?= esc($user['bio']); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Change Avatar</label>
                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp"
                           class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-2.5 rounded-xl text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Security</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">New Password</label>
                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah" 
                               class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Ulangi password baru" 
                               class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<?= view('layout/footer'); ?>

<?php if(session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: <?= json_encode(session()->getFlashdata('success')); ?>,
        confirmButtonColor: '#2563eb',
        timer: 3000,
        showConfirmButton: false
    });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: <?= json_encode(session()->getFlashdata('error')); ?>,
        confirmButtonColor: '#dc2626'
    });
</script>
<?php endif; ?>

</body>
</html>