<!DOCTYPE html>
<html>
<head>

    <title>Organizer Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <h1 class="text-4xl font-bold mb-8">
        Organizer Dashboard 🎉
    </h1>

    <!-- STATS -->
    <div class="grid md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">
                Total Event
            </h2>

            <p class="text-4xl font-bold mt-2">
                <?= $eventCount ?>
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">
                Total Booking
            </h2>

            <p class="text-4xl font-bold mt-2">
                <?= $bookingCount ?>
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">
                Pending
            </h2>

            <p class="text-4xl font-bold mt-2 text-yellow-500">
                <?= $pendingCount ?>
            </p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">
                Approved
            </h2>

            <p class="text-4xl font-bold mt-2 text-green-500">
                <?= $approvedCount ?>
            </p>
        </div>

    </div>

    <!-- EVENT TABLE -->
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-2xl font-bold mb-4">
            My Events
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border">

                <thead class="bg-gray-200">

                    <tr>

                        <th class="p-3 border">
                            Title
                        </th>

                        <th class="p-3 border">
                            Date
                        </th>

                        <th class="p-3 border">
                            Location
                        </th>

                        <th class="p-3 border">
                            Quota
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($events as $event): ?>

                    <tr>

                        <td class="p-3 border">
                            <?= esc($event['title']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= esc($event['date']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= esc($event['location']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= esc($event['quota']); ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= view('layout/footer'); ?>

</body>
</html>