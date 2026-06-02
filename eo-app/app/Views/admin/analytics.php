<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Analytics - Event Organizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class' // PENTING: Untuk mengaktifkan mode malam
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-200 font-sans antialiased transition duration-300">

<?= view('layout/navbar') ?>

<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-7xl">
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Analytics Dashboard</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau performa event, status pemesanan tiket, dan pertumbuhan pengguna.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 lg:col-span-2 transition duration-300">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">User Registration Growth</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500">Tren pendaftaran user baru dalam beberapa bulan terakhir</p>
            </div>
            <div class="relative h-72">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 transition duration-300">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Booking Status</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500">Rasio persetujuan tiket dari seluruh event</p>
            </div>
            <div class="relative h-72 flex justify-center items-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 lg:col-span-3 transition duration-300">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Top 5 Most Popular Events</h2>
                <p class="text-xs text-gray-400 dark:text-gray-500">Event dengan akumulasi jumlah booking terbanyak</p>
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
    blue: { bg: 'rgba(59, 130, 246, 0.15)', border: 'rgba(59, 130, 246, 1)' },
    indigo: { bg: 'rgba(99, 102, 241, 0.2)', border: 'rgba(99, 102, 241, 1)' },
    emerald: 'rgba(16, 185, 129, 0.85)', // Approved
    amber: 'rgba(245, 158, 11, 0.85)',   // Pending
    rose: 'rgba(239, 68, 68, 0.85)'      // Rejected
};

// Deteksi Mode Malam untuk warna Grid Line Chart.js
const isDarkMode = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : '#f3f4f6';
const textColor = isDarkMode ? '#9ca3af' : '#6b7280'; // gray-400 : gray-500

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
            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { stepSize: 1, color: textColor } },
            x: { grid: { display: false }, ticks: { color: textColor } }
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
            borderColor: isDarkMode ? '#111827' : '#ffffff' // Sesuaikan warna border pie chart dengan background
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, color: textColor } }
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
            y: { beginAtZero: true, grid: { color: gridColor }, ticks: { stepSize: 1, color: textColor } },
            x: { grid: { display: false }, ticks: { color: textColor } }
        }
    }
});
</script>

<?= view('layout/footer'); ?>

</body>
</html>