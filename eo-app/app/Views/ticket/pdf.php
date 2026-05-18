<!DOCTYPE html>
<html>
<head>

    <style>

        body{
            font-family: Arial, sans-serif;
            padding:40px;
        }

        .ticket{
            border:3px dashed #333;
            padding:40px;
            border-radius:20px;
        }

        .title{
            font-size:32px;
            font-weight:bold;
            margin-bottom:20px;
        }

        .event{
            font-size:26px;
            color:#2563eb;
            margin-bottom:20px;
        }

        .info{
            margin-bottom:12px;
            font-size:18px;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            color:#777;
        }

    </style>

</head>

<body>

<div class="ticket">

    <div class="title">

        🎫 EVENT TICKET

    </div>

    <div class="event">

        <?= $booking['title']; ?>

    </div>

    <div class="info">

        <strong>Booking ID:</strong>
        #<?= $booking['id']; ?>

    </div>

    <div class="info">

        <strong>Nama:</strong>
        <?= $booking['name']; ?>

    </div>

    <div class="info">

        <strong>Email:</strong>
        <?= $booking['email']; ?>

    </div>

    <div class="info">

        <strong>Lokasi:</strong>
        <?= $booking['location']; ?>

    </div>

    <div class="info">

        <strong>Tanggal:</strong>
        <?= $booking['date']; ?>

    </div>
    <div style="margin-top:30px; text-align:center;">

        <h3>
            QR Verification
        </h3>

        <img
            src="data:image/png;base64,<?= $qrImage; ?>"
            width="180"
        >

        <p>
            Scan untuk validasi ticket
        </p>

    </div>

    <div class="footer">

        Event Organizer Platform

    </div>

</div>

</body>
</html>