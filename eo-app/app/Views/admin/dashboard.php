<!DOCTYPE html>
<html>
<head>

    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DATATABLE -->
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

</head>

<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1 class="text-4xl font-bold text-gray-800">
                Admin Dashboard 📊
            </h1>

            <p class="text-gray-500 mt-2">
                Monitor statistik event, booking, dan aktivitas user.
            </p>

        </div>

        <div class="flex flex-wrap gap-3">

            <a href="/event"
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl shadow">

               Kelola Event

            </a>

            <a href="/admin/export"
               class="bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl shadow">

               Export CSV

            </a>

            <a href="/logout"
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-xl shadow">

               Logout

            </a>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">

        <!-- USERS -->
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Users
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-blue-600">

                        <?= $totalUsers; ?>

                    </h2>

                </div>

                <div class="text-5xl">
                    👤
                </div>

            </div>

        </div>

        <!-- EVENTS -->
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Events
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-purple-600">

                        <?= $totalEvents; ?>

                    </h2>

                </div>

                <div class="text-5xl">
                    🎫
                </div>

            </div>

        </div>

        <!-- BOOKINGS -->
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Bookings
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-green-600">

                        <?= $totalBookings; ?>

                    </h2>

                </div>

                <div class="text-5xl">
                    📅
                </div>

            </div>

        </div>

        <!-- FAVORITES -->
        <div class="bg-white rounded-2xl shadow-lg p-6">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-gray-500">
                        Total Wishlist
                    </p>

                    <h2 class="text-4xl font-bold mt-2 text-pink-600">

                        <?= $totalFavorites; ?>

                    </h2>

                </div>

                <div class="text-5xl">
                    ❤️
                </div>

            </div>

        </div>

    </div>

    <!-- CHART -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Booking Analytics
                </h2>

                <p class="text-gray-500">
                    Statistik jumlah booking tiap event
                </p>

            </div>

        </div>

        <canvas id="bookingChart"></canvas>

    </div>

    <!-- RECENT BOOKINGS -->
    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto">

        <div class="mb-5">

            <h2 class="text-2xl font-bold text-gray-800">
                Recent Booking Activity
            </h2>

            <p class="text-gray-500">
                Aktivitas booking terbaru user
            </p>

        </div>

        <table id="bookingTable"
               class="display w-full">

            <thead>

                <tr>

                    <th>User</th>

                    <th>Event</th>

                    <th>Date Event</th>

                    <th>Location</th>

                    <th>Booked At</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach($bookings as $b): ?>

                    <tr>

                        <td>
                            <?= $b['user_name']; ?>
                        </td>

                        <td>
                            <?= $b['event_title']; ?>
                        </td>

                        <td>
                            <?= $b['date']; ?>
                        </td>

                        <td>
                            <?= $b['location']; ?>
                        </td>

                        <td>
                            <?= $b['created_at']; ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<!-- CHART -->
<script>

const ctx = document.getElementById('bookingChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= $chartLabels; ?>,

        datasets: [{

            label: 'Jumlah Booking',

            data: <?= $chartTotals; ?>,

            borderWidth: 2,

            borderRadius: 10

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: true

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});

</script>

<!-- DATATABLE -->
<script>

$(document).ready(function () {

    $('#bookingTable').DataTable({

        pageLength: 5,

        lengthMenu: [5, 10, 25, 50]

    });

});

</script>

<?= view('layout/footer'); ?>

</body>
</html>