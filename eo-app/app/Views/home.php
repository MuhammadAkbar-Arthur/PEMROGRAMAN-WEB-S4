<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Elevate Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 flex-grow">

    <!-- HERO SECTION (GUEST FRIENDLY) -->
    <div class="relative rounded-2xl overflow-hidden mb-10 shadow-xl border border-gray-200 dark:border-gray-800">
        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
             class="w-full h-[420px] object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/80 to-transparent flex items-center">

            <div class="p-8 md:p-12 text-white max-w-3xl">

                <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs tracking-widest mb-4 uppercase">
                    Platform Event Organizer
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
                    Temukan & Ikuti Event <br> di Sekitarmu
                </h1>

                <p class="text-gray-300 mb-7 text-base md:text-lg leading-relaxed max-w-xl">
                    Jelajahi konser, seminar, workshop, dan berbagai event menarik lainnya dalam satu platform.
                </p>

                <div class="flex flex-wrap gap-3">

                    <a href="#event-section"
                       class="bg-gradient-to-r from-blue-600 to-purple-600 hover:opacity-90 text-white px-7 py-3 rounded-xl font-semibold shadow-lg flex items-center gap-2 transition">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Lihat Event
                    </a>

                    <?php if(!session()->get('logged_in')): ?>
                    <a href="/register"
                       class="bg-white/10 hover:bg-white/20 border border-white/30 backdrop-blur-md px-7 py-3 rounded-xl font-semibold flex items-center gap-2 transition">
                        <i class="fa-solid fa-user-plus"></i>
                        Daftar Gratis
                    </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <!-- SEARCH INFO -->
    <p class="mb-4 text-gray-500 dark:text-gray-400">
        Cari event berdasarkan nama, lokasi, atau kategori
    </p>

    <!-- SEARCH FORM -->
    <form id="searchForm" onsubmit="return false;"
          class="mb-10 bg-white dark:bg-gray-900 p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" id="keyword" name="keyword" placeholder="Cari nama acara..."
                   value="<?= esc($keyword ?? '') ?>"
                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-location-dot text-gray-400"></i>
            </div>
            <input type="text" id="location" name="location" placeholder="Lokasi kota..."
                   value="<?= esc($location ?? '') ?>"
                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-layer-group text-gray-400"></i>
            </div>
            <select name="category" id="category"
                    class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <option value="">Semua Kategori</option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= esc($c['id']); ?>" <?= ($category == $c['id']) ? 'selected' : ''; ?>>
                        <?= esc($c['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-arrow-down-short-wide text-gray-400"></i>
            </div>
            <select name="sort" id="sort"
                    class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <option value="">Terbaru</option>
                <option value="oldest" <?= ($sort=='oldest') ? 'selected' : '' ?>>Terlama</option>
            </select>
        </div>
    </form>

    <!-- EVENT SECTION -->
    <h2 id="event-section" class="text-2xl md:text-3xl font-bold mb-6">
        Event Terbaru
    </h2>

    <div id="eventContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

        <?php $index = 0; foreach($events as $e): ?>
        <div class="event-card bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group"
             style="<?= $index >= 6 ? 'display: none;' : 'display: flex;'; ?>" data-aos="fade-up">

            <div class="overflow-hidden rounded-xl mb-4 relative">

                <?php if($e['image']): ?>
                    <img src="/uploads/<?= esc($e['image'], 'url') ?>"
                         class="h-52 w-full object-cover group-hover:scale-105 transition duration-500">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
                         class="h-52 w-full object-cover grayscale group-hover:scale-105 transition duration-500">
                <?php endif; ?>

                <span class="absolute top-3 left-3 bg-white/90 dark:bg-gray-900/90 px-3 py-1 text-xs font-bold rounded-lg">
                    <?= esc($e['category_name'] ?? 'Uncategorized'); ?>
                </span>

            </div>

            <h2 class="text-xl font-bold mb-3 line-clamp-2">
                <?= esc($e['title']) ?>
            </h2>

            <div class="mt-auto space-y-2 text-sm border-t border-gray-100 dark:border-gray-800 pt-4 mb-4">

                <p class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <i class="fa-solid fa-location-dot text-blue-500"></i>
                    <?= esc($e['location']) ?>
                </p>

                <p class="flex items-center gap-2 text-gray-500">
                    <i class="fa-solid fa-calendar-days text-purple-500"></i>
                    <?= esc($e['date']) ?>
                </p>

            </div>

            <a href="/event/<?= $e['id'] ?>"
               class="mt-auto bg-gray-50 hover:bg-blue-600 text-blue-600 hover:text-white border border-gray-200 dark:border-gray-700 rounded-xl py-3 text-center font-bold transition flex justify-center items-center gap-2">
                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
            </a>

        </div>
        <?php $index++; endforeach; ?>

    </div>

    <div id="loadMoreContainer"
         class="mt-10 justify-center"
         style="<?= count($events) > 6 ? 'display:flex;' : 'display:none;' ?>">

        <button onclick="loadMoreEvents()"
                class="px-6 py-3 bg-white dark:bg-gray-800 border rounded-xl font-semibold hover:bg-gray-100">
            Tampilkan Lebih Banyak
        </button>

    </div>

</main>

<?= view('layout/footer'); ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<script>
const keywordInput = document.getElementById('keyword');
const locationInput = document.getElementById('location');
const categoryInput = document.getElementById('category');
const sortInput = document.getElementById('sort');
const eventContainer = document.getElementById('eventContainer');
const loadMoreBtn = document.getElementById('loadMoreContainer');

let itemsToShow = 6;

function loadMoreEvents() {
    itemsToShow += 6;
    updateVisibility();
}

function updateVisibility() {
    const cards = document.querySelectorAll('.event-card');
    cards.forEach((card, index) => {
        card.style.display = index < itemsToShow ? 'flex' : 'none';
    });

    loadMoreBtn.style.display = cards.length > itemsToShow ? 'flex' : 'none';

    setTimeout(() => AOS.refresh(), 100);
}

async function loadEvents() {
    const response = await fetch(`/search-event?keyword=${keywordInput.value}&location=${locationInput.value}&category=${categoryInput.value}&sort=${sortInput.value}`);
    const events = await response.json();

    let html = '';

    if (events.length === 0) {
        html = `<div class="col-span-3 text-center p-10">Tidak ada event</div>`;
    } else {
        events.forEach((event, index) => {
            html += `
            <div class="event-card bg-white dark:bg-gray-900 p-5 rounded-2xl border flex flex-col" style="display:${index<6?'flex':'none'}">
                <h2 class="font-bold">${event.title}</h2>
            </div>`;
        });
    }

    eventContainer.innerHTML = html;
    itemsToShow = 6;
    updateVisibility();
}

keywordInput.addEventListener('keyup', loadEvents);
locationInput.addEventListener('keyup', loadEvents);
categoryInput.addEventListener('change', loadEvents);
sortInput.addEventListener('change', loadEvents);
</script>

</body>
</html>