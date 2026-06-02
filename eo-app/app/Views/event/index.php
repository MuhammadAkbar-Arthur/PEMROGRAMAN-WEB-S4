<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100">
    
    <?= view('layout/navbar'); ?>

    <div class="container mx-auto p-4 md:p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Event List</h1>
            <a href="/event/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Event
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 rounded-2xl p-6">
            <table id="eventTable" class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Organizer</th>
                        <th class="p-3 text-left">Location</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($events as $e): ?>
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-3"><?= $no++ ?></td>
                        <td class="p-3 font-medium"><?= esc($e['title']) ?></td>
                        <td class="p-3"><?= esc($e['date']) ?></td>
                        <td class="p-3"><?= esc($e['organizer_name'] ?? 'Admin') ?></td>
                        <td class="p-3">
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($e['location']); ?>" 
                               target="_blank" 
                               class="text-blue-500 hover:underline flex items-center gap-1">
                               📍 <?= esc($e['location']) ?>
                            </a>
                        </td>
                        <td class="p-3 flex gap-2">
                            <?php 
                            // Ambil ID user dari session
                            $userId = session()->get('id');
                            $userRole = session()->get('role');

                            // Cek apakah user adalah pemilik event atau seorang Admin
                            if ($userRole === 'admin' || ($userRole === 'organizer' && $e['owner_id'] == $userId)): 
                            ?>
                                <a href="/event/edit/<?= $e['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                    Edit
                                </a>
                                <a href="/event/delete/<?= $e['id'] ?>" class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition">
                                    Hapus
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables
            $('#eventTable').DataTable();

            // Logic Delete dengan SweetAlert2
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    Swal.fire({
                        title: 'Yakin?',
                        text: "Data event ini akan dihapus permanen!",
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
        });
    </script>

    <?= view('layout/footer'); ?>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({ icon: 'success', title: 'Berhasil 🎉', text: '<?= session()->getFlashdata('success'); ?>', confirmButtonColor: '#2563eb' });
    </script>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({ icon: 'error', title: 'Oops 😢', text: '<?= session()->getFlashdata('error'); ?>', confirmButtonColor: '#dc2626' });
    </script>
    <?php endif; ?>

</body>
</html>