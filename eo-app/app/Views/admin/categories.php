<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-950 text-gray-800 dark:text-gray-200 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 max-w-6xl">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                Kelola Kategori 🏷️
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Tambah dan kelola kategori event.
            </p>
        </div>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 p-4 rounded-lg mb-6 border border-green-200 dark:border-green-800">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 p-4 rounded-lg mb-6 border border-red-200 dark:border-red-800">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6 mb-8 border border-gray-200 dark:border-gray-800">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
            Tambah Kategori
        </h2>
        <form action="/admin/categories/store" method="post">
            <div class="flex flex-col md:flex-row gap-4">
                <input
                    type="text"
                    name="name"
                    placeholder="Nama kategori baru..."
                    class="flex-1 border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold">
                    Tambah
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800">
        <div class="p-6 border-b dark:border-gray-800">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Daftar Kategori
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-800">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-20">ID</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="3" class="p-8 text-center text-gray-400">Belum ada kategori.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($categories as $c): ?>
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition duration-150">
                        <td class="p-4 text-gray-500 dark:text-gray-400 font-mono text-sm">
                            <?= $c['id']; ?>
                        </td>
                        <td class="p-4 font-medium text-gray-900 dark:text-white">
                            <?= esc($c['name']); ?>
                        </td>
                        <td class="p-4 flex gap-2">
                            <button 
                                type="button"
                                onclick="openEditModal('<?= $c['id']; ?>', '<?= esc($c['name'], 'js'); ?>')"
                                class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition duration-150">
                                Edit
                            </button>
                            <a href="/admin/categories/delete/<?= $c['id']; ?>"
                            class="delete-category-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition duration-150">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto h-full w-full">
    <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl max-w-md w-full p-6 border border-gray-200 dark:border-gray-800 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ubah Nama Kategori</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl font-bold">&times;</button>
        </div>
        <form id="editForm" method="post">
            <div class="mb-5">
                <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Kategori</label>
                <input 
                    type="text" 
                    id="edit_name" 
                    name="name" 
                    class="w-full border dark:border-gray-700 bg-white dark:bg-gray-800 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-white" 
                    required>
            </div>
            <div class="flex justify-end gap-3">
                <button 
                    type="button" 
                    onclick="closeEditModal()" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    const input = document.getElementById('edit_name');
    
    // Set action URL form secara dinamis menuju method update di controller
    form.action = '/admin/categories/update/' + id;
    // Set value input nama kategori saat ini
    input.value = name;
    
    // Tampilkan modal
    modal.classList.remove('hidden');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
}

// Menutup modal jika area luar modal di-klik
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}
</script>

<?= view('layout/footer'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Logic SweetAlert untuk Hapus Kategori
    $('body').on('click', '.delete-category-btn', function(e) {
        e.preventDefault(); 
        const url = $(this).attr('href');

        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Kategori yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
</body>
</html>