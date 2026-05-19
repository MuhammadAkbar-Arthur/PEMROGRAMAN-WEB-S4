<!DOCTYPE html>
<html>
<head>

    <title>Ticket Verification</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white dark:bg-gray-900 shadow-2xl rounded-2xl p-10 max-w-lg w-full text-center">

    <div class="text-6xl mb-4">
        ✅
    </div>

    <h1 class="text-3xl font-bold text-green-600 mb-4">
        Ticket Valid
    </h1>

    <div class="space-y-3 text-left">

        <p>
            <strong>Nama:</strong>
            <?= $booking['name']; ?>
        </p>

        <p>
            <strong>Event:</strong>
            <?= $booking['title']; ?>
        </p>

        <p>
            <strong>Tanggal:</strong>
            <?= $booking['date']; ?>
        </p>

        <p>
            <strong>Lokasi:</strong>
            <?= $booking['location']; ?>
        </p>

        <p>
            <strong>Status:</strong>

            <span class="text-green-600 font-bold">
                <?= strtoupper($booking['status']); ?>
            </span>
        </p>

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