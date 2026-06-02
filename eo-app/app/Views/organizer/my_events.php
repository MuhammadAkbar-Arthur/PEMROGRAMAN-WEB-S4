<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-950">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
            My Events
        </h1>
        <a href="/event/create"
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg shadow transition">
            + Create Event
        </a>
    </div>

    <?php if(empty($events)): ?>
        <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow text-center border border-gray-200 dark:border-gray-800">
            <h2 class="text-2xl font-bold mb-2 text-gray-700 dark:text-white">
                Belum ada event
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-5">
                Mulai buat event pertamamu 🚀
            </p>
            <a href="/event/create"
               class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-lg inline-block transition">
                Create Event
            </a>
        </div>
    <?php else: ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            <?php foreach($events as $e): ?>
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden flex flex-col h-full border border-gray-200 dark:border-gray-800 transition">
                    <img src="/uploads/<?= esc($e['image']); ?>" class="w-full h-52 object-cover">
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-3">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white"><?= esc($e['title']); ?></h2>
                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs px-3 py-1 rounded-full font-medium">
                                <?= esc($e['category_name']); ?>
                            </span>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            <?= esc($e['description']); ?>
                        </p>
                        
                        <div class="mt-auto">
                            <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <p>📍 <?= esc($e['location']); ?></p>
                                <p>📅 <?= esc($e['date']); ?></p>
                                <p>👥 Quota: <?= esc($e['quota']); ?></p>
                            </div>

                            <div class="flex gap-3">
                                <a href="/event/<?= $e['id']; ?>" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-lg transition">
                                    Lihat
                                </a>

                                <a href="/event/edit/<?= $e['id']; ?>" 
                                class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white text-center py-2 rounded-lg transition">
                                Edit
                                </a>
                                
                                <a href="/event/delete/<?= $e['id']; ?>" 
                                class="delete-btn flex-1 bg-red-500 hover:bg-red-600 text-white text-center py-2 rounded-lg transition">
                                Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
<?= view('layout/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah pindah halaman langsung
        const url = this.getAttribute('href');

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data event ini akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Merah Tailwind
            cancelButtonColor: '#6b7280',  // Abu-abu Tailwind
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Pindah ke link hapus jika klik OK
            }
        });
    });
});
</script>
</body>
</html>