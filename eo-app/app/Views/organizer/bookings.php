<!DOCTYPE html>
<html>
<head>

    <title>Organizer Bookings</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <h1 class="text-4xl font-bold mb-8">
        Manage Bookings 🎟️
    </h1>

    <?php if(session()->getFlashdata('success')): ?>

        <div class="bg-green-100 text-green-700 p-4 rounded mb-5">

            <?= session()->getFlashdata('success'); ?>

        </div>

    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>

        <div class="bg-red-100 text-red-700 p-4 rounded mb-5">

            <?= session()->getFlashdata('error'); ?>

        </div>

    <?php endif; ?>

    <div class="bg-white rounded shadow p-6 overflow-x-auto">

        <table class="w-full border">

            <thead class="bg-gray-200">

                <tr>

                    <th class="border p-3">
                        User
                    </th>

                    <th class="border p-3">
                        Email
                    </th>

                    <th class="border p-3">
                        Event
                    </th>

                    <th class="border p-3">
                        Date
                    </th>

                    <th class="border p-3">
                        Status
                    </th>

                    <th class="border p-3">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($bookings as $booking): ?>

                <tr>

                    <td class="border p-3">
                        <?= esc($booking['name']); ?>
                    </td>

                    <td class="border p-3">
                        <?= esc($booking['email']); ?>
                    </td>

                    <td class="border p-3">
                        <?= esc($booking['title']); ?>
                    </td>

                    <td class="border p-3">
                        <?= esc($booking['date']); ?>
                    </td>

                    <td class="border p-3">

                        <?php if($booking['status'] == 'pending'): ?>

                            <span class="text-yellow-500 font-bold">
                                Pending
                            </span>

                        <?php elseif($booking['status'] == 'approved'): ?>

                            <span class="text-green-500 font-bold">
                                Approved
                            </span>

                        <?php else: ?>

                            <span class="text-red-500 font-bold">
                                Rejected
                            </span>

                        <?php endif; ?>

                    </td>

                    <td class="border p-3">

                        <?php if($booking['status'] == 'pending'): ?>

                            <a href="/organizer/booking/approve/<?= $booking['id']; ?>"
                               class="bg-green-500 text-white px-4 py-2 rounded">

                               Approve

                            </a>

                            <a href="/organizer/booking/reject/<?= $booking['id']; ?>"
                               class="bg-red-500 text-white px-4 py-2 rounded">

                               Reject

                            </a>

                        <?php else: ?>

                            <span class="text-gray-400">
                                Done
                            </span>

                        <?php endif; ?>

                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?= view('layout/footer'); ?>

</body>
</html>