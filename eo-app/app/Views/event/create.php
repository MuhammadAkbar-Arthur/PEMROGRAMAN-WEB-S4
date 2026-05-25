<!DOCTYPE html>
<html>
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

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 shadow rounded p-6">

        <h1 class="text-3xl font-bold mb-6">
            Tambah Event
        </h1>

        <?php if(session()->getFlashdata('errors')): ?>

            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">

                <ul class="list-disc ml-5">

                    <?php foreach(session()->getFlashdata('errors') as $error): ?>

                        <li><?= $error ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <form method="post"
              action="/event/store"
              enctype="multipart/form-data">

            <!-- TITLE -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Judul Event
                </label>

                <input type="text"
                       name="title"
                       value="<?= old('title'); ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="5"
                          class="w-full border p-3 rounded-lg"
                          required><?= old('description'); ?></textarea>

            </div>

            <!-- CATEGORY -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Category
                </label>

                <select name="category_id"
                        class="w-full border p-3 rounded-lg"
                        required>

                    <option value="">
                        -- Pilih Category --
                    </option>

                    <?php foreach($categories as $c): ?>

                        <option value="<?= $c['id']; ?>"

                        <?= old('category_id') == $c['id']
                            ? 'selected'
                            : ''; ?>>

                            <?= $c['name']; ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- DATE -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Tanggal
                </label>

                <input type="date"
                       name="date"
                       value="<?= old('date'); ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <!-- LOCATION -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Lokasi
                </label>

                <input type="text"
                       name="location"
                       value="<?= old('location'); ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <!-- IMAGE -->
            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Gambar Event
                </label>

                <input type="file"
                       name="image"
                       class="w-full border p-3 rounded-lg">

            </div>

            <!-- QUOTA -->
            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Kuota Peserta
                </label>

                <input type="number"
                       name="quota"
                       value="<?= old('quota'); ?>"
                       placeholder="Contoh: 100"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg">

                Simpan Event

            </button>

        </form>

    </div>

</div>

<?= view('layout/footer'); ?>

<?php if(session()->getFlashdata('success')): ?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil 🎉',

    text: '<?= session()->getFlashdata('success'); ?>',

    confirmButtonColor: '#2563eb'

});

</script>

<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>

<script>

Swal.fire({

    icon: 'error',

    title: 'Oops 😢',

    text: '<?= session()->getFlashdata('error'); ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>