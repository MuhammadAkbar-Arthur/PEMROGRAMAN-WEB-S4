<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-950 transition duration-300 min-h-screen">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-800 transition">
        
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Edit Event</h1>

        <form method="post" action="/event/update/<?= $event['id'] ?>" enctype="multipart/form-data">
            
            <?php 
            // Variabel helper untuk konsistensi gaya input dark mode
            $inputClass = "w-full border p-3 rounded-lg bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none transition";
            $labelClass = "block mb-2 font-semibold text-gray-700 dark:text-gray-300";
            ?>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Judul Event</label>
                <input type="text" name="title" value="<?= $event['title'] ?>" class="<?= $inputClass ?>" required>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Deskripsi</label>
                <textarea name="description" rows="5" class="<?= $inputClass ?>" required><?= $event['description'] ?></textarea>
            </div>

            <div class="mb-4">
                <label class="<?= $labelClass ?>">Category</label>
                <select name="category_id" class="<?= $inputClass ?>" required>
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id']; ?>" <?= ($event['category_id'] == $c['id']) ? 'selected' : ''; ?>>
                            <?= $c['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="<?= $labelClass ?>">Tanggal</label>
                    <input type="date" name="date" value="<?= $event['date'] ?>" class="<?= $inputClass ?>" required>
                </div>
                <div>
                    <label class="<?= $labelClass ?>">Lokasi</label>
                    <input type="text" name="location" value="<?= $event['location'] ?>" class="<?= $inputClass ?>" required>
                </div>
            </div>

            <?php if($event['image']): ?>
                <div class="mb-4">
                    <label class="<?= $labelClass ?>">Gambar Saat Ini</label>
                    <img src="/uploads/<?= $event['image'] ?>" class="w-full h-60 object-cover rounded-lg border dark:border-gray-700">
                </div>
            <?php endif; ?>

            <div class="mb-6">
                <label class="<?= $labelClass ?>">Ganti Gambar</label>
                <input type="file" name="image" class="<?= $inputClass ?>">
            </div>

            <div class="mb-6">
                <label class="<?= $labelClass ?>">Kuota Peserta</label>
                <input type="number" name="quota" value="<?= $event['quota']; ?>" class="<?= $inputClass ?>" required>
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition shadow-md shadow-yellow-500/30">
                Update Event
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