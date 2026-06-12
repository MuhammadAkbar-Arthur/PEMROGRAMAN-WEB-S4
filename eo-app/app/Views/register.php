<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Elevate</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070')] bg-cover bg-center bg-no-repeat bg-fixed min-h-screen">

<div class="min-h-screen flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">

    <div class="bg-white/95 dark:bg-gray-900/95 shadow-2xl rounded-2xl overflow-hidden flex flex-col lg:flex-row max-w-5xl w-full border border-white/20 dark:border-gray-700/50">

        <!-- LEFT PANEL -->
        <div class="hidden lg:flex flex-col justify-center items-center text-white p-12 bg-gradient-to-br from-blue-600/90 via-indigo-600/90 to-purple-700/90 lg:w-5/12 relative overflow-hidden">

            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-400/20 rounded-full blur-xl"></div>

            <div class="relative z-10 text-center flex flex-col items-center">
                <img src="<?= base_url('assets/images/logo.png'); ?>" class="w-28 h-28 mb-3 object-contain">
                <h1 class="text-4xl font-extrabold mb-3">Elevate</h1>
                <div class="w-16 h-1 bg-white rounded-full mb-5 opacity-70"></div>
                <p class="text-sm text-blue-50 max-w-sm leading-relaxed">
                    Platform event untuk mencari, membuat, dan mengelola acara dengan mudah.
                </p>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="p-6 sm:p-10 w-full lg:w-7/12 flex flex-col justify-center max-h-[95vh] overflow-y-auto dark:text-gray-100">

            <div class="text-center lg:text-left mb-6">
                <img src="<?= base_url('assets/images/logo.png'); ?>" class="w-14 h-14 mb-3 lg:hidden mx-auto">

                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">
                    Buat Akun Baru
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Isi data dengan benar untuk melanjutkan
                </p>
            </div>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-r-lg mb-5 text-sm">
                    <p class="font-bold mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        Terdapat kesalahan:
                    </p>
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/register/process" method="post" class="space-y-4">

                <!-- ROLE -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Daftar sebagai:
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- USER -->
                        <div id="role-user"
                             class="border p-4 rounded-2xl cursor-pointer flex gap-3 bg-gray-50 dark:bg-gray-800 hover:border-blue-400 transition active"
                             onclick="toggleRole('user')">

                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 text-blue-600">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <div>
                                <p class="font-bold">Peserta</p>
                                <p class="text-xs text-gray-500">Ikut & pesan event</p>
                            </div>

                            <input type="radio" name="role" value="user" id="user" class="hidden" checked>
                        </div>

                        <!-- ORGANIZER -->
                        <div id="role-organizer"
                             class="border p-4 rounded-2xl cursor-pointer flex gap-3 bg-gray-50 dark:bg-gray-800 hover:border-purple-400 transition"
                             onclick="toggleRole('organizer')">

                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-purple-100 text-purple-600">
                                <i class="fa-solid fa-building"></i>
                            </div>

                            <div>
                                <p class="font-bold">Organizer</p>
                                <p class="text-xs text-gray-500">Buat & kelola event</p>
                            </div>

                            <input type="radio" name="role" value="organizer" id="organizer" class="hidden">
                        </div>

                    </div>
                </div>

                <!-- NAME -->
                <div>
                    <label class="text-sm font-semibold">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <i class="fa-solid fa-user absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="text" name="name" value="<?= old('name'); ?>"
                               class="w-full pl-11 py-3 rounded-xl border bg-gray-50 dark:bg-gray-800"
                               placeholder="Nama lengkap" required>
                    </div>
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="text-sm font-semibold">Email</label>
                    <div class="relative mt-1">
                        <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-gray-400"></i>
                        <input type="email" name="email" value="<?= old('email'); ?>"
                               class="w-full pl-11 py-3 rounded-xl border bg-gray-50 dark:bg-gray-800"
                               placeholder="email@gmail.com" required>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label class="text-sm font-semibold">Password</label>
                        <div class="relative mt-1">
                            <i class="fa-solid fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                            <input type="password" name="password"
                                   class="w-full pl-11 py-3 rounded-xl border bg-gray-50 dark:bg-gray-800"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold">Konfirmasi</label>
                        <div class="relative mt-1">
                            <i class="fa-solid fa-shield absolute left-4 top-3.5 text-gray-400"></i>
                            <input type="password" name="confirm_password"
                                   class="w-full pl-11 py-3 rounded-xl border bg-gray-50 dark:bg-gray-800"
                                   required>
                        </div>
                    </div>

                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-bold mt-4 hover:opacity-90 transition">
                    Daftar Sekarang
                </button>

            </form>

            <p class="text-center text-sm mt-6 text-gray-500">
                Sudah punya akun?
                <a href="/login" class="text-blue-600 font-bold">Login</a>
            </p>

        </div>

    </div>
</div>

<script>
function toggleRole(role) {
    document.getElementById('user').checked = false;
    document.getElementById('organizer').checked = false;

    document.getElementById('role-user').classList.remove('border-blue-500');
    document.getElementById('role-organizer').classList.remove('border-purple-500');

    if (role === 'user') {
        document.getElementById('user').checked = true;
        document.getElementById('role-user').classList.add('border-blue-500');
    } else {
        document.getElementById('organizer').checked = true;
        document.getElementById('role-organizer').classList.add('border-purple-500');
    }
}
</script>

</body>
</html>