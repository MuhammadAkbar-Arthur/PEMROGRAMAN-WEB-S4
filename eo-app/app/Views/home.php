<!DOCTYPE html>
<html>
<head>
    <title>Event Organizer</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

</head>

<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <!-- HERO SECTION -->
    <div class="relative rounded-2xl overflow-hidden mb-10 shadow-lg">

        <!-- IMAGE -->
        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
             class="w-full h-[450px] object-cover">

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/50 flex items-center">

            <div class="p-10 text-white max-w-2xl">

                <h1 class="text-5xl font-bold mb-4 leading-tight">

                    Discover Amazing Events Near You 🎉

                </h1>

                <p class="text-lg mb-6 text-gray-200">

                    Temukan konser, seminar, workshop,
                    dan event terbaik hanya dalam satu platform.

                </p>

                <div class="flex gap-4">

                    <a href="#event-section"
                       class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-lg font-semibold">

                        Explore Events

                    </a>

                    <?php if(!session()->get('id')): ?>

                    <a href="/register"
                       class="bg-white text-black hover:bg-gray-200 px-6 py-3 rounded-lg font-semibold">

                        Join Now

                    </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Event Organizer
        </h1>

        <div class="flex gap-2">

            <?php if(session()->get('id')): ?>

                <a href="/my-bookings"
                   class="bg-blue-500 text-white px-4 py-2 rounded">
                   My Booking
                </a>

                <a href="/logout"
                   class="bg-red-500 text-white px-4 py-2 rounded">
                   Logout
                </a>

            <?php else: ?>

                <a href="/login"
                   class="bg-green-500 text-white px-4 py-2 rounded">
                   Login
                </a>

            <?php endif; ?>

        </div>

    </div>

    <!-- SEARCH -->
    <form id="searchForm" class="mb-6 flex gap-2">

        <input type="text"
               id="keyword"
               name="keyword"
               placeholder="Cari event..."
               value="<?= $keyword ?? '' ?>"
               class="border p-2 rounded w-full">

        <input type="text"
               id="location"
               name="location"
               placeholder="Lokasi..."
               value="<?= $location ?? '' ?>"
               class="border p-2 rounded w-full">

        <!-- CATEGORY -->
        <select name="category"
                id="category"
                class="border p-2 rounded">

            <option value="">
                Semua Category
            </option>

            <?php foreach($categories as $c): ?>

                <option value="<?= $c['id']; ?>"

                    <?= ($category == $c['id']) ? 'selected' : ''; ?>>

                    <?= $c['name']; ?>

                </option>

            <?php endforeach; ?>

        </select>

        <!-- SORT -->
        <select name="sort" id="sort" class="border p-2 rounded">

            <option value="">
                Terbaru
            </option>

            <option value="oldest"
                <?= ($sort=='oldest') ? 'selected' : '' ?>>
                Terlama
            </option>

        </select>

        <button class="bg-blue-500 text-white px-4 rounded">
            Cari
        </button>

    </form>

    <!-- EVENT -->
    <div id="event-section">

        <div id="eventContainer" class="grid md:grid-cols-3 gap-6">

            <?php foreach($events as $e): ?>

            <div class="bg-white p-4 shadow rounded
                        hover:shadow-2xl
                        hover:-translate-y-2
                        transition-all duration-300"
                data-aos="fade-up">

                <?php if($e['image']): ?>

                    <img src="/uploads/<?= $e['image'] ?>"
                        class="mb-3 h-48 w-full object-cover rounded">

                <?php endif; ?>

                <!-- CATEGORY -->
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                    <?= $e['category_name'] ?? 'No Category'; ?>

                </span>

                <!-- TITLE -->
                <h2 class="text-xl font-bold mb-2 mt-3">
                    <?= $e['title'] ?>
                </h2>

                <!-- LOCATION -->
                <p class="text-gray-600">
                    📍 <?= $e['location'] ?>
                </p>

                <!-- DATE -->
                <p class="text-gray-500 mb-3">
                    📅 <?= $e['date'] ?>
                </p>

                <!-- BUTTON -->
                <a href="/event/<?= $e['id'] ?>"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block">

                   Detail

                </a>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">

        <?= $pager
            ->only(['keyword', 'location', 'category', 'sort'])
            ->links('default', 'tailwind'); ?>

    </div>

</div>

<!-- AOS SCRIPT -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>

    AOS.init({

        duration: 800

    });

</script>
<script>

const keywordInput = document.getElementById('keyword');

const locationInput = document.getElementById('location');

const categoryInput = document.getElementById('category');

const sortInput = document.getElementById('sort');

const eventContainer = document.getElementById('eventContainer');

// FUNCTION SEARCH
async function loadEvents()
{
    const keyword = keywordInput.value;

    const location = locationInput.value;

    const category = categoryInput.value;

    const sort = sortInput.value;

    const response = await fetch(

        `/search-event?keyword=${keyword}&location=${location}&category=${category}&sort=${sort}`

    );

    const events = await response.json();

    let html = '';

    if (events.length === 0) {

        html = `

            <div class="col-span-3">

                <div class="bg-white p-10 rounded-xl text-center shadow">

                    <h2 class="text-2xl font-bold text-gray-700 mb-2">

                        😢 Event Tidak Ditemukan

                    </h2>

                    <p class="text-gray-500">

                        Coba keyword atau filter lain

                    </p>

                </div>

            </div>

        `;

    } else {

        events.forEach(event => {

            html += `

            <div class="bg-white p-4 shadow rounded
                        hover:shadow-2xl
                        hover:-translate-y-2
                        transition-all duration-300">

                ${
                    event.image
                    ?
                    `<img src="/uploads/${event.image}"
                        class="mb-3 h-48 w-full object-cover rounded">`
                    :
                    ''
                }

                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                    ${event.category_name ?? 'No Category'}

                </span>

                <h2 class="text-xl font-bold mb-2 mt-3">

                    ${event.title}

                </h2>

                <p class="text-gray-600">

                    📍 ${event.location}

                </p>

                <p class="text-gray-500 mb-3">

                    📅 ${event.date}

                </p>

                <a href="/event/${event.id}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-block">

                    Detail

                </a>

            </div>

            `;
        });

    }

    eventContainer.innerHTML = html;
}

// EVENT LISTENER
keywordInput.addEventListener('keyup', loadEvents);

locationInput.addEventListener('keyup', loadEvents);

categoryInput.addEventListener('change', loadEvents);

sortInput.addEventListener('change', loadEvents);

</script>
<?= view('layout/footer'); ?>

</body>
</html>