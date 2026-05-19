<!DOCTYPE html>
<html>
<head>
    <style>

        body{
            font-family: Arial;
            background:#f3f4f6;
            padding:30px;
        }

        .card{
            background:white;
            border-radius:12px;
            padding:30px;
            max-width:600px;
            margin:auto;
        }

        .title{
            font-size:28px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .status{
            display:inline-block;
            padding:10px 18px;
            border-radius:999px;
            color:white;
            font-weight:bold;
            margin-bottom:20px;
        }

        .pending{
            background:#f59e0b;
        }

        .approved{
            background:#10b981;
        }

        .rejected{
            background:#ef4444;
        }

    </style>
</head>

<body>

<div class="card">

    <div class="title">
        🎟 Event Booking Notification
    </div>

    <p>
        Halo <b><?= $booking['name']; ?></b>
    </p>

    <p>
        Booking event kamu:
    </p>

    <h2>
        <?= $booking['title']; ?>
    </h2>

    <p>
        📍 <?= $booking['location']; ?>
    </p>

    <p>
        📅 <?= $booking['date']; ?>
    </p>

    <br>

    <div class="status <?= $booking['status']; ?>">

        <?= strtoupper($booking['status']); ?>

    </div>

    <p>
        <?php if($booking['status'] == 'pending'): ?>

            Booking kamu sedang menunggu approval admin.

        <?php elseif($booking['status'] == 'approved'): ?>

            Booking kamu berhasil diapprove 🎉

        <?php else: ?>

            Maaf, booking kamu ditolak.

        <?php endif; ?>
    </p>

    <br>

    <p>
        Terima kasih sudah menggunakan Event Organizer 🚀
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