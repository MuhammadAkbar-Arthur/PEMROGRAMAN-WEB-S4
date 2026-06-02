<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-950 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-800 transition">
        
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">
            Tambah Event
        </h1>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 p-4 rounded-lg mb-5 border border-red-200 dark:border-red-800">
                <ul class="list-disc ml-5">
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/event/store" enctype="multipart/form-data">
            
            <?php 
            $inputClass = "w-full border p-3 rounded-lg bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition";
            $labelClass = "block mb-2 font-semibold text-gray-700 dark:text-gray-300";
            ?>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Judul Event</label>
                <input type="text" name="title" value="<?= old('title'); ?>" class="<?= $inputClass ?>" required>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Deskripsi</label>
                <textarea name="description" rows="5" class="<?= $inputClass ?>" required><?= old('description'); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Category</label>
                <select name="category_id" class="<?= $inputClass ?>" required>
                    <option value="">-- Pilih Category --</option>
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id']; ?>" <?= old('category_id') == $c['id'] ? 'selected' : ''; ?>>
                            <?= $c['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Tanggal</label>
                <input type="date" name="date" value="<?= old('date'); ?>" class="<?= $inputClass ?>" required>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Lokasi</label>
                <input type="text" name="location" value="<?= old('location'); ?>" class="<?= $inputClass ?>" required>
            </div>

            <div class="mb-6">
                <label class="<?= $labelClass ?>">Gambar Event</label>
                <input type="file" name="image" class="<?= $inputClass ?>">
            </div>

            <div class="mb-6">
                <label class="<?= $labelClass ?>">Kuota Peserta</label>
                <input type="number" name="quota" value="<?= old('quota'); ?>" placeholder="Contoh: 100" class="<?= $inputClass ?>" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-md shadow-blue-500/20">
                Simpan Event
            </button>
        </form>
    </div>
</div>

<?= view('layout/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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