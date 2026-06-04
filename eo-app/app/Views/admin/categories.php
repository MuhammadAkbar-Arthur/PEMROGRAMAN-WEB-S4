<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-200 transition duration-300 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 max-w-6xl flex-grow mt-4 mb-12">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-tags text-blue-600 dark:text-blue-400"></i> Kelola Kategori
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Tambah, ubah, dan kelola klasifikasi kategori acara di dalam sistem.
            </p>
        </div>
        <a href="/admin" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0">
            <i class="fa-solid fa-chart-line"></i> Dashboard Admin
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-3xl p-6 md:p-8 mb-8 border border-gray-100 dark:border-gray-800 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-blue-500 to-indigo-500"></div>
        
        <h2 class="text-xl font-bold mb-5 text-gray-800 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-circle-plus text-blue-500"></i> Tambah Kategori Baru
        </h2>
        
        <form action="/admin/categories/store" method="post">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" name="name" placeholder="Ketik nama kategori (Misal: Konser, Seminar, Workshop)..."
                           class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-gray-900 dark:text-white font-medium" required>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3.5 rounded-xl transition duration-200 font-bold shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 shrink-0">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-list text-indigo-500"></i> Daftar Kategori Tersedia
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/60 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="p-5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24 text-center">ID</th>
                        <th class="p-5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                        <th class="p-5 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php if(empty($categories)): ?>
                        <tr>
                            <td colspan="3" class="p-10 text-center text-gray-400 dark:text-gray-500 font-medium">
                                <i class="fa-solid fa-box-open text-3xl mb-3 block"></i>
                                Belum ada data kategori.
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php foreach($categories as $c): ?>
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/40 transition duration-150">
                        <td class="p-5 text-center text-gray-400 dark:text-gray-500 font-mono text-sm font-bold">
                            #<?= $c['id']; ?>
                        </td>
                        <td class="p-5 font-bold text-gray-900 dark:text-white text-base">
                            <span class="bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 px-3 py-1 rounded-lg border border-blue-100 dark:border-blue-800/50">
                                <?= esc($c['name']); ?>
                            </span>
                        </td>
                        <td class="p-5 flex justify-end gap-2">
                            <button type="button" onclick="openEditModal('<?= $c['id']; ?>', '<?= esc($c['name'], 'js'); ?>')"
                                    class="inline-flex items-center gap-1.5 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-600 border border-amber-200 dark:border-amber-900/50 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </button>
                            <a href="/admin/categories/delete/<?= $c['id']; ?>"
                               class="delete-category-btn inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 border border-rose-200 dark:border-rose-900/50 dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="editModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto transition-opacity">
    <div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-2xl max-w-md w-full p-8 border border-gray-100 dark:border-gray-800 transform transition-all scale-95 opacity-0" id="modalContent">
        
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-500"></i> Ubah Nama Kategori
            </h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-rose-500 transition text-2xl font-bold">&times;</button>
        </div>
        
        <form id="editForm" method="post">
            <div class="mb-6">
                <label for="edit_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Kategori Baru</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" id="edit_name" name="name" 
                           class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 text-gray-900 dark:text-white font-medium" required>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-md shadow-amber-500/30 transition flex items-center gap-2">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?= view('layout/footer'); ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openEditModal(id, name) {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('modalContent');
        const form = document.getElementById('editForm');
        const input = document.getElementById('edit_name');
        
        form.action = '/admin/categories/update/' + id;
        input.value = name;
        
        modal.classList.remove('hidden');
        // Trigger reflow for animation
        void modal.offsetWidth;
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('modalContent');
        
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => { modal.classList.add('hidden'); }, 150);
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) { closeEditModal(); }
    }

    // Logic SweetAlert untuk Hapus Kategori
    $(document).ready(function () {
        $('body').on('click', '.delete-category-btn', function(e) {
            e.preventDefault(); 
            const url = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Kategori yang dihapus akan hilang dari sistem. Lanjutkan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-trash-can mr-2"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
                customClass: { confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = url; }
            });
        });
    });
</script>

<?php if(session()->getFlashdata('success')): ?>
<script>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: <?= json_encode(session()->getFlashdata('success')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });</script>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
<script>Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: <?= json_encode(session()->getFlashdata('error')); ?>, showConfirmButton: false, timer: 3000, background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff', color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827' });</script>
<?php endif; ?>

</body>
</html>