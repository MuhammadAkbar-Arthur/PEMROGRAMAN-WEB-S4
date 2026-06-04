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

    <div class="relative rounded-2xl overflow-hidden mb-10 shadow-2xl border border-gray-200 dark:border-gray-800">
        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-[450px] object-cover">
        
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/80 to-transparent flex items-center">
            <div class="p-8 md:p-12 text-white max-w-3xl">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-sm font-semibold tracking-wider mb-4 uppercase">
                    Platform Event Terdepan
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-5 leading-tight tracking-tight">
                    Temukan Acara Luar Biasa <br> di Sekitarmu
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-300 font-light max-w-xl leading-relaxed">
                    Eksplorasi konser musik, seminar inspiratif, hingga workshop kreatif hanya dengan beberapa klik di Elevate.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#event-section" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-purple-500/30 transition transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Eksplor Acara
                    </a>
                    
                    <?php if(!session()->get('logged_in')): ?>
                    <a href="/register" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-3.5 rounded-xl font-bold transition transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Bergabung Sekarang
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <form id="searchForm" onsubmit="return false;" class="mb-10 bg-white dark:bg-gray-900 p-4 sm:p-5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-magnifying-glass text-gray-400"></i></div>
            <input type="text" id="keyword" name="keyword" placeholder="Cari nama acara..." value="<?= esc($keyword ?? '') ?>" 
                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-location-dot text-gray-400"></i></div>
            <input type="text" id="location" name="location" placeholder="Lokasi kota..." value="<?= esc($location ?? '') ?>" 
                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-layer-group text-gray-400 z-10"></i></div>
            <select name="category" id="category" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer appearance-none text-sm">
                <option value="">Semua Kategori</option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= esc($c['id']); ?>" <?= ($category == $c['id']) ? 'selected' : ''; ?>>
                        <?= esc($c['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none"><i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i></div>
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-arrow-down-short-wide text-gray-400 z-10"></i></div>
            <select name="sort" id="sort" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 dark:text-white pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer appearance-none text-sm">
                <option value="">Terbaru Ditambahkan</option>
                <option value="oldest" <?= ($sort=='oldest') ? 'selected' : '' ?>>Terlama Ditambahkan</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none"><i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i></div>
        </div>
    </form>

    <div id="event-section">
        <div id="eventContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            <?php $index = 0; foreach($events as $e): ?>
            <div class="event-card bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex-col h-full group" 
                 style="<?= $index >= 6 ? 'display: none;' : 'display: flex;'; ?>" data-aos="fade-up">
                
                <div class="overflow-hidden rounded-xl mb-4 relative">
                    <?php if($e['image']): ?>
                        <img src="/uploads/<?= esc($e['image'], 'url') ?>" class="h-52 w-full object-cover shadow-sm group-hover:scale-105 transition duration-500">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="h-52 w-full object-cover shadow-sm filter grayscale-[30%] group-hover:scale-105 transition duration-500">
                    <?php endif; ?>
                    
                    <span class="absolute top-3 left-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-blue-700 dark:text-blue-400 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm">
                        <?= esc($e['category_name'] ?? 'Uncategorized'); ?>
                    </span>
                </div>

                <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white line-clamp-2 leading-snug">
                    <?= esc($e['title']) ?>
                </h2>

                <div class="mt-auto space-y-2.5 mb-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-location-dot w-4 text-center text-blue-500"></i>
                        <span class="truncate font-medium"><?= esc($e['location']) ?></span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-calendar-days w-4 text-center text-purple-500"></i>
                        <span class="font-medium"><?= esc($e['date']) ?></span>
                    </p>
                </div>

                <a href="/event/<?= $e['id'] ?>" class="w-full bg-gray-50 hover:bg-blue-600 text-blue-600 hover:text-white dark:bg-gray-800 dark:hover:bg-blue-600 dark:text-blue-400 dark:hover:text-white border border-gray-200 dark:border-gray-700 hover:border-transparent text-center px-4 py-3 rounded-xl font-bold transition duration-200 flex justify-center items-center gap-2">
                    Lihat Detail Acara <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>
            <?php $index++; endforeach; ?>

        </div>

        <div id="loadMoreContainer" class="mt-12 justify-center" style="<?= count($events) > 6 ? 'display: flex;' : 'display: none;'; ?>">
            <button type="button" onclick="loadMoreEvents()" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-8 py-3.5 rounded-xl font-bold shadow-sm transition transform hover:-translate-y-1 flex items-center gap-2">
                Tampilkan Lebih Banyak <i class="fa-solid fa-chevron-down"></i>
            </button>
        </div>
    </div>

</main>

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

let itemsToShow = 6; 

function loadMoreEvents() {
    itemsToShow += 6;
    updateVisibility();
}

function updateVisibility() {
    const cards = document.querySelectorAll('.event-card');
    cards.forEach((card, index) => {
        if (index < itemsToShow) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });

    if (cards.length > itemsToShow) {
        loadMoreBtn.style.display = 'flex';
    } else {
        loadMoreBtn.style.display = 'none';
    }

    setTimeout(() => { AOS.refresh(); }, 100);
}

// SEARCH AJAX
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
                <div class="bg-white dark:bg-gray-900 border border-dashed border-gray-300 dark:border-gray-700 shadow-sm rounded-2xl p-16 text-center">
                    <div class="text-5xl mb-4 text-gray-400"><i class="fa-solid fa-face-frown-open"></i></div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Acara Tidak Ditemukan</h2>
                    <p class="text-gray-500 dark:text-gray-400">Silakan coba gunakan kata kunci atau filter lokasi lain.</p>
                </div>
            </div>
        `;
        loadMoreBtn.style.display = 'none';
    } else {
        events.forEach((event, index) => {
            const displayStyle = index >= 6 ? 'none' : 'flex';
            const imageHtml = event.image 
                ? `<img src="/uploads/${event.image}" class="h-52 w-full object-cover shadow-sm group-hover:scale-105 transition duration-500">` 
                : `<img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="h-52 w-full object-cover shadow-sm filter grayscale-[30%] group-hover:scale-105 transition duration-500">`;

            html += `
            <div class="event-card bg-white dark:bg-gray-900 shadow-sm rounded-2xl p-5 border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex-col h-full group" style="display: ${displayStyle};" data-aos="fade-up">
                
                <div class="overflow-hidden rounded-xl mb-4 relative">
                    ${imageHtml}
                    <span class="absolute top-3 left-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-blue-700 dark:text-blue-400 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm">
                        ${event.category_name ?? 'Uncategorized'}
                    </span>
                </div>

                <h2 class="text-xl font-bold mb-3 text-gray-900 dark:text-white line-clamp-2 leading-snug">
                    ${event.title}
                </h2>

                <div class="mt-auto space-y-2.5 mb-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-location-dot w-4 text-center text-blue-500"></i>
                        <span class="truncate font-medium">${event.location}</span>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm flex items-center gap-3">
                        <i class="fa-solid fa-calendar-days w-4 text-center text-purple-500"></i>
                        <span class="font-medium">${event.date}</span>
                    </p>
                </div>

                <a href="/event/${event.id}" class="w-full bg-gray-50 hover:bg-blue-600 text-blue-600 hover:text-white dark:bg-gray-800 dark:hover:bg-blue-600 dark:text-blue-400 dark:hover:text-white border border-gray-200 dark:border-gray-700 hover:border-transparent text-center px-4 py-3 rounded-xl font-bold transition duration-200 flex justify-center items-center gap-2">
                    Lihat Detail Acara <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>
            `;
        });
    }

    eventContainer.innerHTML = html;
    
    itemsToShow = 6;
    if (events.length > 0) {
        updateVisibility();
    }
}

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