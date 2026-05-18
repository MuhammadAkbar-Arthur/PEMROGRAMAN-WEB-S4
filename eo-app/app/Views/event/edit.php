<!DOCTYPE html>
<html>
<head>

    <title>Edit Event</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-6">

    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">

        <h1 class="text-3xl font-bold mb-6">
            Edit Event
        </h1>

        <form method="post"
              action="/event/update/<?= $event['id'] ?>"
              enctype="multipart/form-data">

            <!-- TITLE -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Judul Event
                </label>

                <input type="text"
                       name="title"
                       value="<?= $event['title'] ?>"
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
                          required><?= $event['description'] ?></textarea>

            </div>

            <!-- CATEGORY -->
            <div class="mb-4">

                <label class="block mb-2 font-semibold">
                    Category
                </label>

                <select name="category_id"
                        class="w-full border p-3 rounded-lg"
                        required>

                    <?php foreach($categories as $c): ?>

                        <option value="<?= $c['id']; ?>"

                            <?= ($event['category_id'] == $c['id']) ? 'selected' : ''; ?>>

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
                       value="<?= $event['date'] ?>"
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
                       value="<?= $event['location'] ?>"
                       class="w-full border p-3 rounded-lg"
                       required>

            </div>

            <!-- CURRENT IMAGE -->
            <?php if($event['image']): ?>

                <div class="mb-4">

                    <label class="block mb-2 font-semibold">
                        Gambar Saat Ini
                    </label>

                    <img src="/uploads/<?= $event['image'] ?>"
                         class="w-full h-60 object-cover rounded-lg">

                </div>

            <?php endif; ?>

            <!-- IMAGE -->
            <div class="mb-6">

                <label class="block mb-2 font-semibold">
                    Ganti Gambar
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
                    value="<?= $event['quota']; ?>"
                    class="w-full border p-3 rounded-lg"
                    required>

            </div>

            <button
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

                Update Event

            </button>

        </form>

    </div>

</div>

<?= view('layout/footer'); ?>

</body>
</html>