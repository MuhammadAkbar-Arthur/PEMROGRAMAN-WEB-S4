<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics - Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

<?= view('layout/navbar') ?>

<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-7xl">
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Analytics Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau performa event, status pemesanan tiket, dan pertumbuhan pengguna.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900">User Registration Growth</h2>
                <p class="text-xs text-gray-400">Tren pendaftaran user baru dalam beberapa bulan terakhir</p>
            </div>
            <div class="relative h-72">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900">Booking Status</h2>
                <p class="text-xs text-gray-400">Rasio persetujuan tiket dari seluruh event</p>
            </div>
            <div class="relative h-72 flex justify-center items-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-3">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900">Top 5 Most Popular Events</h2>
                <p class="text-xs text-gray-400">Event dengan akumulasi jumlah booking terbanyak</p>
            </div>
            <div class="relative h-80">
                <canvas id="eventChart"></canvas>
            </div>
        </div>

    </div>
</div>

<script>
// Konfigurasi Warna Global Tailwind Modern
const colors = {
    blue: { bg: 'rgba(59, 130, 246, 0.1)', border: 'rgba(59, 130, 246, 1)' },
    indigo: { bg: 'rgba(99, 102, 241, 0.2)', border: 'rgba(99, 102, 241, 1)' },
    emerald: 'rgba(16, 185, 129, 1)', // Approved
    amber: 'rgba(245, 158, 11, 1)',   // Pending
    rose: 'rgba(239, 68, 68, 1)'       // Rejected
};

// 1. CHART: USER GROWTH (LINE CHART)
new Chart(document.getElementById('growthChart'), {
    type: 'line',
    data: {
        labels: <?= $growthLabels ?>,
        datasets: [{
            label: 'New Users Registered',
            data: <?= $growthTotals ?>,
            backgroundColor: colors.blue.bg,
            borderColor: colors.blue.border,
            borderWidth: 3,
            fill: true,
            tension: 0.35,
            pointBackgroundColor: colors.blue.border,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});

// 2. CHART: BOOKING STATUS (PIE CHART)
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: <?= $statusLabels ?>,
        datasets: [{
            data: <?= $statusTotals ?>,
            backgroundColor: [colors.amber, colors.emerald, colors.rose],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } }
        }
    }
});

// 3. CHART: TOP EVENTS (BAR CHART)
new Chart(document.getElementById('eventChart'), {
    type: 'bar',
    data: {
        labels: <?= $eventLabels ?>,
        datasets: [{
            label: 'Total Bookings',
            data: <?= $eventTotals ?>,
            backgroundColor: colors.indigo.bg,
            borderColor: colors.indigo.border,
            borderWidth: 2,
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});
</script>

</body>
</html>