<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gradient-to-r from-purple-500 to-blue-500 min-h-screen flex items-center justify-center">

<div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl overflow-hidden w-full max-w-5xl grid md:grid-cols-2">

    <!-- LEFT -->
    <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-blue-600 to-purple-700 text-white p-10">

        <h1 class="text-3xl md:text-5xl font-bold mb-4">
            Join Us
        </h1>

        <p class="text-center text-lg opacity-90">
            Buat akun dan mulai booking event favoritmu.
        </p>

    </div>

    <!-- RIGHT -->
    <div class="p-10">

        <h2 class="text-3xl font-bold mb-6 text-center">
            Register
        </h2>

        <?php if(session()->getFlashdata('errors')): ?>

            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">

                <ul class="list-disc ml-5">

                    <?php foreach(session()->getFlashdata('errors') as $error): ?>

                        <li><?= esc($error) ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>
        
        <form action="/register/process" method="post">

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Nama
                </label>

                <input type="text"
                    name="name"
                    value="<?= esc(old('name')); ?>"
                    class="w-full border p-3 rounded-lg"
                    required>

            </div>

            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="<?= esc(old('email')); ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg hover:opacity-90 transition">

                Register

            </button>

        </form>

        <div class="mt-4 text-center">

            <a href="/login" class="text-blue-500">
                Sudah punya akun? Login
            </a>

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

    text: '<?= session()->getFlashdata('error'); ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>