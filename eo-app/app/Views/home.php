<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Organizer Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 min-h-screen">

    <div class="relative rounded-2xl overflow-hidden mb-10 shadow-xl border border-gray-200 dark:border-gray-800">
        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-[450px] object-cover">
        
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-black/40 flex items-center">
            <div class="p-10 text-white max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight tracking-tight">
                    Discover Amazing Events Near You 🎉
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-200 font-light">
                    Temukan konser, seminar, workshop, dan event terbaik hanya dalam satu platform modern.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#event-section" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                        Explore Events
                    </a>
                    
                    <?php if(!session()->get('logged_in')): ?>
                    <a href="/register" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-3 rounded-xl font-semibold transition transform hover:-translate-y-1">
                        Join Now
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <form id="searchForm" onsubmit="return false;" class="mb-10 bg-white dark:bg-gray-900 p-4 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 flex flex-col md:flex-row gap-3">
        
        <input type="text" id="keyword" name="keyword" placeholder="🔍 Cari nama event..." value="<?= esc($keyword ?? '') ?>" 
               class="flex-1 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">

        <input type="text" id="location" name="location" placeholder="📍 Lokasi..." value="<?= esc($location ?? '') ?>" 
               class="flex-1 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition">

        <select name="category" id="category" class="flex-1 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
            <option value="">Semua Kategori</option>
            <?php foreach($categories as $c): ?>
                <option value="<?= esc($c['id']); ?>" <?= ($category == $c['id']) ? 'selected' : ''; ?>>
                    <?= esc($c['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort" id="sort" class="flex-1 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
            <option value="">Terbaru</option>
            <option value="oldest" <?= ($sort=='oldest') ? 'selected' : '' ?>>Terlama</option>
        </select>
    </form>

    <div id="event-section">
        <div id="eventContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php $index = 0; foreach($events as $e): ?>
            <div class="event-card bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex-col h-full" 
                 style="<?= $index >= 6 ? 'display: none;' : 'display: flex;'; ?>" data-aos="fade-up">
                
                <?php if($e['image']): ?>
                    <img src="/uploads/<?= esc($e['image'], 'url') ?>" class="mb-4 h-48 w-full object-cover rounded-xl shadow-sm">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="mb-4 h-48 w-full object-cover rounded-xl shadow-sm filter grayscale-[30%]">
                <?php endif; ?>

                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                        <?= esc($e['category_name'] ?? 'Uncategorized'); ?>
                    </span>
                </div>

                <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white line-clamp-2">
                    <?= esc($e['title']) ?>
                </h2>

                <div class="mt-auto space-y-2 mb-5">
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📍</span> <span class="truncate"><?= esc($e['location']) ?></span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📅</span> <span><?= esc($e['date']) ?></span>
                    </p>
                </div>

                <a href="/event/<?= $e['id'] ?>" class="w-full bg-gray-50 hover:bg-blue-600 text-blue-600 hover:text-white dark:bg-gray-800 dark:hover:bg-blue-600 dark:text-blue-400 dark:hover:text-white border border-gray-200 dark:border-gray-700 hover:border-transparent text-center px-4 py-2.5 rounded-xl font-medium transition duration-200">
                    Lihat Detail
                </a>
            </div>
            <?php $index++; endforeach; ?>

        </div>

        <div id="loadMoreContainer" class="mt-10 justify-center" style="<?= count($events) > 6 ? 'display: flex;' : 'display: none;'; ?>">
            <button type="button" onclick="loadMoreEvents()" class="bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-medium shadow-md transition transform hover:-translate-y-1">
                Lihat Lebih Banyak ↓
            </button>
        </div>
    </div>

</div>

<?= view('layout/footer'); ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
</script>

<script>
const keywordInput = document.getElementById('keyword');
const locationInput = document.getElementById('location');
const categoryInput = document.getElementById('category');
const sortInput = document.getElementById('sort');
const eventContainer = document.getElementById('eventContainer');
const loadMoreBtn = document.getElementById('loadMoreContainer');

let itemsToShow = 6; // Batas awal item yang ditampilkan

function loadMoreEvents() {
    itemsToShow += 6;
    updateVisibility();
}

function updateVisibility() {
    const cards = document.querySelectorAll('.event-card');
    
    // Ganti class hidden/flex dengan manipulasi style.display murni
    cards.forEach((card, index) => {
        if (index < itemsToShow) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });

    // Kontrol tombol Load More
    if (cards.length > itemsToShow) {
        loadMoreBtn.style.display = 'flex';
    } else {
        loadMoreBtn.style.display = 'none';
    }

    // Pancing animasi AOS untuk elemen baru yang baru muncul
    setTimeout(() => { AOS.refresh(); }, 100);
}

// FUNCTION SEARCH AJAX
async function loadEvents() {
    const keyword = keywordInput.value;
    const location = locationInput.value;
    const category = categoryInput.value;
    const sort = sortInput.value;

    const response = await fetch(`/search-event?keyword=${keyword}&location=${location}&category=${category}&sort=${sort}`);
    const events = await response.json();

    let html = '';

    if (events.length === 0) {
        html = `
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <div class="bg-white dark:bg-gray-900 border border-dashed border-gray-300 dark:border-gray-700 shadow-sm rounded-2xl p-12 text-center">
                    <div class="text-6xl mb-4">😢</div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Event Tidak Ditemukan</h2>
                    <p class="text-gray-500 dark:text-gray-400">Silakan coba gunakan kata kunci atau filter lokasi lain.</p>
                </div>
            </div>
        `;
        loadMoreBtn.style.display = 'none';
    } else {
        events.forEach((event, index) => {
            // Setup style untuk card hasil search (sembunyikan yang lebih dari ke-6)
            const displayStyle = index >= 6 ? 'none' : 'flex';
            const imageHtml = event.image 
                ? `<img src="/uploads/${event.image}" class="mb-4 h-48 w-full object-cover rounded-xl shadow-sm">` 
                : `<img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="mb-4 h-48 w-full object-cover rounded-xl shadow-sm filter grayscale-[30%]">`;

            html += `
            <div class="event-card bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex-col h-full" style="display: ${displayStyle};" data-aos="fade-up">
                
                ${imageHtml}

                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                        ${event.category_name ?? 'Uncategorized'}
                    </span>
                </div>

                <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white line-clamp-2">
                    ${event.title}
                </h2>

                <div class="mt-auto space-y-2 mb-5">
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📍</span> <span class="truncate">${event.location}</span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2">
                        <span>📅</span> <span>${event.date}</span>
                    </p>
                </div>

                <a href="/event/${event.id}" class="w-full bg-gray-50 hover:bg-blue-600 text-blue-600 hover:text-white dark:bg-gray-800 dark:hover:bg-blue-600 dark:text-blue-400 dark:hover:text-white border border-gray-200 dark:border-gray-700 hover:border-transparent text-center px-4 py-2.5 rounded-xl font-medium transition duration-200">
                    Lihat Detail
                </a>
            </div>
            `;
        });
    }

    eventContainer.innerHTML = html;
    
    // Kembalikan batas tampilan ke 6 lagi setelah pencarian baru dilakukan
    itemsToShow = 6;
    if (events.length > 0) {
        updateVisibility();
    }
}

// EVENT LISTENER
keywordInput.addEventListener('keyup', loadEvents);
locationInput.addEventListener('keyup', loadEvents);
categoryInput.addEventListener('change', loadEvents);
sortInput.addEventListener('change', loadEvents);
</script>

<?php if(session()->getFlashdata('success')): ?>
<script>
    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: <?= json_encode(session()->getFlashdata('success')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script>
    Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: <?= json_encode(session()->getFlashdata('error')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });
</script>
<?php endif; ?>

</body>
</html>