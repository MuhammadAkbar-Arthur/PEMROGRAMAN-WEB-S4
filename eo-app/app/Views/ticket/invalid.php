<!DOCTYPE html>
<html>
<head>

    <title>Invalid Ticket</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-red-100 min-h-screen flex items-center justify-center">

<div class="bg-white dark:bg-gray-900 shadow rounded p-6 text-center">

    <div class="text-6xl mb-4">
        ❌
    </div>

    <h1 class="text-3xl font-bold text-red-600 mb-3">
        Ticket Invalid
    </h1>

    <p class="text-gray-600">
        Ticket tidak ditemukan, rejected, atau belum di-approve admin.
    </p>

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