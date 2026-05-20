<!DOCTYPE html>
<html>
<head>

    <title>Profile</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<script>

function showLoading(button)
{
    button.disabled = true;

    button.innerHTML = 'Loading...';
}

</script>
<body class="bg-gray-100 dark:bg-gray-950 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6">

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow rounded p-6">

        <h1 class="text-3xl font-bold mb-6">
            My Profile
        </h1>

        <?php if(session()->getFlashdata('success')): ?>

            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">

                <?= session()->getFlashdata('success'); ?>

            </div>

        <?php endif; ?>

        <!-- AVATAR -->
        <div class="flex justify-center mb-6">

            <?php if($user['avatar']): ?>

                <img src="/uploads/<?= esc($user['avatar'], 'url'); ?>"
                     class="w-32 h-32 rounded-full object-cover border-4 border-blue-500">

            <?php else: ?>

                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-4xl">

                    👤

                </div>

            <?php endif; ?>

        </div>

        <form action="/profile/update"
              method="post"
              enctype="multipart/form-data">

            <!-- NAME -->
            <div class="mb-4">

                <label class="block font-semibold mb-2">
                    Name
                </label>

                <input type="text"
                       name="name"
                       value="<?= esc($user['name']); ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <!-- EMAIL -->
            <div class="mb-4">

                <label class="block font-semibold mb-2">
                    Email
                </label>

                <input type="email"
                       value="<?= esc($user['email']); ?>"
                       class="w-full border p-3 rounded-lg bg-gray-100"
                       disabled>

            </div>

            <!-- PHONE -->
            <div class="mb-4">

                <label class="block font-semibold mb-2">
                    Phone
                </label>

                <input type="text"
                       name="phone"
                       value="<?= esc($user['phone']); ?>"
                       class="w-full border p-3 rounded-lg">

            </div>

            <!-- BIO -->
            <div class="mb-4">

                <label class="block font-semibold mb-2">
                    Bio
                </label>

                <textarea name="bio"
                          class="w-full border p-3 rounded-lg"
                          rows="4"><?= esc($user['bio']); ?></textarea>

            </div>

            <!-- AVATAR -->
            <div class="mb-4">

                <label class="block font-semibold mb-2">
                    Avatar
                </label>

                <input type="file"
                       name="avatar"
                       class="w-full border p-3 rounded-lg">

            </div>

            <!-- PASSWORD -->
            <div class="mb-6">

                <label class="block font-semibold mb-2">
                    New Password
                </label>

                <input type="password"
                       name="password"
                       placeholder="Kosongkan jika tidak ingin mengubah password"
                       class="w-full border p-3 rounded-lg">

            </div>

            <button onclick="showLoading(this)"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg">

                Update Profile

            </button>

        </form>

    </div>

</div>

<?= view('layout/footer'); ?>

<?php if(session()->getFlashdata('success')): ?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil 🎉',

    text: <?= json_encode(session()->getFlashdata('success')); ?>,

    confirmButtonColor: '#2563eb'

});

</script>

<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>

<script>

Swal.fire({

    icon: 'error',

    title: 'Oops 😢',

    text: <?= json_encode(session()->getFlashdata('error')); ?>,

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>