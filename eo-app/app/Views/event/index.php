<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Seluruh Acara - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    
    <!-- FontAwesome & Plugins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <style>
        /* =========================================================
           CUSTOM DATATABLES UNTUK TAILWIND & DARK MODE 
           ========================================================= */
        table.dataTable { border-collapse: collapse !important; width: 100% !important; margin-top: 15px !important; margin-bottom: 15px !important; }
        table.dataTable thead th { border-bottom: 2px solid #e5e7eb !important; padding: 12px 10px !important; font-size: 13px; text-transform: uppercase; color: #6b7280; }
        table.dataTable tbody td { border-bottom: 1px solid #f3f4f6 !important; padding: 12px 10px !important; vertical-align: middle; }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d1d5db !important; border-radius: 8px !important; padding: 6px 12px !important; background-color: #f9fafb !important; outline: none !important; transition: border 0.3s;
        }
        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus { border-color: #3b82f6 !important; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2) !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 8px !important; border: 1px solid transparent !important; margin: 0 2px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #3b82f6 !important; color: white !important; border-color: #3b82f6 !important; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2) !important; }
        
        /* Dark Mode Overrides */
        .dark table.dataTable thead th { border-bottom-color: #374151 !important; color: #9ca3af !important; }
        .dark table.dataTable tbody td { border-bottom-color: #1f2937 !important; color: #d1d5db !important; }
        .dark .dataTables_wrapper .dataTables_length select,
        .dark .dataTables_wrapper .dataTables_filter input { border-color: #4b5563 !important; background-color: #111827 !important; color: white !important; }
        .dark .dataTables_wrapper .dataTables_info { color: #9ca3af !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button { color: #9ca3af !important; }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:not(.current):hover { background: #374151 !important; border-color: #4b5563 !important; color: white !important; }
        .dark table.dataTable tbody tr { background-color: transparent !important; }
        .dark table.dataTable tbody tr:hover { background-color: rgba(31, 41, 55, 0.5) !important; }
        .dark .dataTables_empty { color: #9ca3af !important; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">
    
    <?= view('layout/navbar'); ?>

    <main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 tracking-tight flex items-center gap-3">
                    <i class="fa-solid fa-list-ul text-blue-600 dark:text-blue-400"></i> Daftar Acara
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                    Katalog lengkap seluruh acara yang terdaftar di dalam sistem Elevate.
                </p>
            </div>
            <a href="/event/create" class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition transform hover:-translate-y-1 flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-plus"></i> Tambah Acara
            </a>
        </div>

        <!-- TABEL KONTEN -->
        <div class="bg-white dark:bg-gray-900 shadow-sm border border-gray-100 dark:border-gray-800 rounded-3xl p-6 md:p-8 overflow-x-auto">
            <table id="eventTable" class="display w-full">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No</th>
                        <th>Judul Acara</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Penyelenggara</th>
                        <th>Lokasi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($events as $e): ?>
                    <tr>
                        <td class="text-center font-mono text-gray-500 dark:text-gray-400 font-bold"><?= $no++ ?></td>
                        <td class="font-bold text-gray-900 dark:text-white"><?= esc($e['title']) ?></td>
                        <td>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 whitespace-nowrap">
                                <i class="fa-regular fa-calendar"></i> <?= esc($e['date']) ?>
                            </span>
                        </td>
                        <td class="font-medium text-gray-600 dark:text-gray-300">
                            <?= esc($e['organizer_name'] ?? 'Sistem Admin') ?>
                        </td>
                        <td>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($e['location']); ?>" 
                               target="_blank" 
                               class="inline-flex items-center gap-1.5 text-rose-500 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 transition font-medium text-sm whitespace-nowrap"
                               title="Buka di Google Maps">
                                <i class="fa-solid fa-map-location-dot"></i> <?= esc($e['location']) ?>
                            </a>
                        </td>
                        <td>
                            <div class="flex gap-2 items-center justify-end">
                                <!-- Tombol Lihat Detail (Tersedia untuk semua orang) -->
                                <a href="/event/<?= $e['id'] ?>" class="inline-flex items-center gap-1.5 bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-600 border border-blue-200 dark:border-blue-800/50 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>

                                <?php 
                                // Cek kepemilikan dan hak akses
                                $userId = session()->get('id');
                                $userRole = session()->get('role');

                                if ($userRole === 'admin' || ($userRole === 'organizer' && $e['owner_id'] == $userId)): 
                                ?>
                                    <a href="/event/edit/<?= $e['id'] ?>" class="inline-flex items-center gap-1.5 bg-amber-50 hover:bg-amber-500 hover:text-white text-amber-600 border border-amber-200 dark:border-amber-800/50 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:bg-amber-600 dark:hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="/event/delete/<?= $e['id'] ?>" class="delete-btn inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 border border-rose-200 dark:border-rose-900/50 dark:bg-rose-900/20 dark:text-rose-400 dark:hover:bg-rose-600 dark:hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?= view('layout/footer'); ?>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables
            $('#eventTable').DataTable({
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ acara",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ acara",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "Maju",
                        previous: "Mundur"
                    }
                }
            });

            // Logic Delete dengan SweetAlert2
            $('body').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                Swal.fire({
                    title: 'Hapus Acara Ini?',
                    text: "Data acara beserta seluruh tiket pesanan di dalamnya akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626', // rose-600
                    cancelButtonColor: '#6b7280',  // gray-500
                    confirmButtonText: '<i class="fa-solid fa-trash-can mr-2"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
                    customClass: { confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    <!-- Flash Messages (Toasts) -->
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