<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Acara: <?= esc($event['title']); ?> - Elevate</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-950 transition duration-300 flex flex-col min-h-screen">

<?= view('layout/navbar'); ?>

<main class="container mx-auto p-4 md:p-6 lg:px-24 flex-grow mt-4 mb-12">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b border-gray-200 dark:border-gray-800 pb-6 max-w-4xl mx-auto">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-500 dark:from-amber-400 dark:to-orange-400 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-pen-to-square text-amber-500 dark:text-amber-400"></i> Edit Acara
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">
                Ubah informasi dan detail acara yang telah Anda terbitkan sebelumnya.
            </p>
        </div>
        <a href="<?= session()->get('role') === 'admin' ? '/event' : '/organizer/my-events'; ?>" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 font-bold text-sm shrink-0 w-full md:w-auto justify-center">
            <i class="fa-solid fa-arrow-left"></i> Batal
        </a>
    </div>

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 shadow-xl border border-gray-100 dark:border-gray-800 rounded-3xl overflow-hidden relative">
        <div class="h-2 bg-gradient-to-r from-amber-500 to-orange-500 w-full absolute top-0 left-0"></div>

        <div class="p-6 md:p-10 pt-10">
            
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 p-5 rounded-2xl mb-8 flex items-start gap-4">
                    <i class="fa-solid fa-circle-exclamation text-xl mt-0.5"></i>
                    <ul class="list-disc ml-2 space-y-1 font-medium text-sm">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="/event/update/<?= $event['id'] ?>" enctype="multipart/form-data" class="space-y-6">
                
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2">
                    <i class="fa-solid fa-circle-info text-amber-500 mr-2"></i> Informasi Dasar
                </h3>

                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Judul Acara</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-heading text-gray-400"></i>
                        </div>
                        <input type="text" name="title" value="<?= esc($event['title']); ?>" 
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Deskripsi Lengkap</label>
                    <div class="relative">
                        <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                            <i class="fa-solid fa-align-left text-gray-400"></i>
                        </div>
                        <textarea name="description" rows="5" 
                                  class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium" required><?= esc($event['description']); ?></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Kategori</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-tags text-gray-400"></i>
                            </div>
                            <select name="category_id" class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-10 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium appearance-none" required>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?= $c['id']; ?>" <?= ($event['category_id'] == $c['id']) ? 'selected' : ''; ?>>
                                        <?= $c['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Tanggal Acara</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-calendar-day text-gray-400"></i>
                            </div>
                            <input type="date" name="date" value="<?= esc($event['date']); ?>" 
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-12 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Lokasi Acara</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                            </div>
                            <input type="text" name="location" value="<?= esc($event['location']); ?>" 
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Kuota Peserta</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-users text-gray-400"></i>
                            </div>
                            <input type="number" name="quota" value="<?= esc($event['quota']); ?>" min="1"
                                   class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 pl-11 pr-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 transition text-gray-900 dark:text-white font-medium" required>
                        </div>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4 mt-8 text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-2 pt-4">
                    <i class="fa-solid fa-image text-orange-500 mr-2"></i> Media Visual
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center bg-gray-50 dark:bg-gray-800/30 p-5 rounded-2xl border border-gray-100 dark:border-gray-800">
                    
                    <?php if($event['image']): ?>
                        <div class="w-full">
                            <label class="block text-xs font-bold mb-2 text-gray-500 dark:text-gray-400 uppercase tracking-widest">Poster Saat Ini</label>
                            <img src="/uploads/<?= esc($event['image'], 'url'); ?>" class="w-full h-40 md:h-48 object-cover rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        </div>
                    <?php endif; ?>

                    <div class="w-full h-full flex flex-col justify-center">
                        <label class="block text-xs font-bold mb-2 text-gray-500 dark:text-gray-400 uppercase tracking-widest">Ganti Poster (Opsional)</label>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-full min-h-[160px] border-2 border-amber-300 dark:border-amber-700/50 border-dashed rounded-xl cursor-pointer bg-amber-50/50 dark:bg-amber-900/10 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition group">
                            <div class="flex flex-col items-center justify-center p-4 text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-amber-400 dark:text-amber-500 mb-2 group-hover:-translate-y-1 transition-transform"></i>
                                <p class="mb-1 text-sm text-gray-600 dark:text-gray-400 font-bold"><span class="text-amber-600 dark:text-amber-500">Klik untuk unggah</span> file baru</p>
                                <p class="text-[10px] text-gray-500 dark:text-gray-500 font-medium uppercase mt-1">Kosongkan jika tidak ingin mengubah</p>
                            </div>
                            <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/png, image/jpeg, image/webp" />
                        </label>
                    </div>

                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-800 mt-8">
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold py-4 rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 text-lg">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?= view('layout/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Script interaktif untuk upload gambar
    document.getElementById('dropzone-file').addEventListener('change', function(e) {
        if(e.target.files.length > 0) {
            var fileName = e.target.files[0].name;
            var labelText = this.previousElementSibling.querySelector('p span');
            labelText.textContent = "Terpilih: " + fileName;
            labelText.classList.remove('text-amber-600', 'dark:text-amber-500');
            labelText.classList.add('text-emerald-600', 'dark:text-emerald-400');
        }
    });
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