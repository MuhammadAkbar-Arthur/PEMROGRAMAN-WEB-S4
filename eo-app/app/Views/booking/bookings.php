<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
</head>

<body>
    <?= view('layout/navbar'); ?>

<h1>My Bookings</h1>

<a href="/">← Kembali</a>

<table border="1">
    <tr>
        <th>No</th>
        <th>Event</th>
        <th>Date</th>
        <th>Location</th>
        <th>Aksi</th>
        <th>Status</th>
    </tr>

    <?php $no=1; foreach($bookings as $b): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $b['title'] ?></td>
        <td><?= $b['date'] ?></td>
        <td><?= $b['location'] ?></td>
        <td>
            <a href="/ticket/<?= $b['id'] ?>"
                class="bg-blue-500 text-white px-3 py-1 rounded">

                Ticket

            </a>
            <a href="/booking/delete/<?= $b['id'] ?>">Batal</a>
        </td>
        <td>

            <?php if($b['status'] == 'pending'): ?>

                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

                    Pending

                </span>

            <?php elseif($b['status'] == 'approved'): ?>

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                    Approved

                </span>

            <?php elseif($b['status'] == 'rejected'): ?>

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                    Rejected

                </span>

            <?php endif; ?>

        </td>
    </tr>
    <?php endforeach; ?>

</table>
<?= view('layout/footer'); ?>
</body>
</html>