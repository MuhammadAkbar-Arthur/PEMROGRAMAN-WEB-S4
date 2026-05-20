<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">

<div class="bg-white dark:bg-gray-900 shadow rounded p-6">

    <!-- LEFT -->
    <div class="hidden md:flex flex-col justify-center items-center text-white p-10">

        <h1 class="text-3xl md:text-5xl font-bold mb-4">
            Event Organizer
        </h1>

        <p class="text-lg text-center opacity-90">
            Platform modern untuk booking dan manajemen event.
        </p>

    </div>

    <!-- RIGHT -->
    <div class="bg-white dark:bg-gray-900 shadow rounded p-6">

        <h2 class="text-3xl font-bold mb-6 text-center">
            Login
        </h2>

        <?php if(session()->getFlashdata('error')): ?>

            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">

                <?= esc(session()->getFlashdata('error')); ?>

            </div>

        <?php endif; ?>

        <form action="/login/process" method="post">

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                       placeholder="Masukkan email"
                       required>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400"
                       placeholder="Masukkan password"
                       required>

            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg hover:opacity-90 transition">

                Login

            </button>

        </form>

        <div class="mt-6 text-center text-gray-500 text-sm">

            © <?= date('Y') ?> Event Organizer System
            <div class="mt-4 text-center">

                <a href="/register"
                class="text-blue-500">
                Belum punya akun? Register
                </a>

            </div>

        </div>

    </div>

</div>

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

    text: '<?= esc(session()->getFlashdata('error')); ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>