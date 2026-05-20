<!DOCTYPE html>
<html>
<head>

    <title>My Wishlist</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>
<script>

function confirmDelete(event)
{
    event.preventDefault();

    const url = event.currentTarget.href;

    Swal.fire({

        title: 'Yakin?',
        text: 'Data akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya'

    }).then((result) => {

        if(result.isConfirmed) {

            window.location.href = url;

        }

    });

    return false;
}

</script>
<body class="bg-gray-100 dark:bg-gray-950 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold">
                ❤️ My Wishlist
            </h1>

            <p class="text-gray-500 mt-2">
                Semua event favorit kamu ada di sini
            </p>

        </div>

        <a href="/"
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl">

           ← Back Home

        </a>

    </div>

    <!-- EMPTY STATE -->
    <?php if(empty($favorites)): ?>

        <div class="bg-white dark:bg-gray-900 shadow rounded p-6">

            <h2 class="text-2xl font-bold mb-3">
                Wishlist masih kosong 😢
            </h2>

            <p class="text-gray-500 mb-6">
                Yuk tambahkan event favoritmu sekarang
            </p>

            <a href="/"
               class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-xl">

               Explore Events

            </a>

        </div>

    <?php else: ?>

    <!-- CARD GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <?php foreach($favorites as $f): ?>

        <div class="bg-white dark:bg-gray-900 shadow rounded p-6 shadow-lg overflow-hidden
                    hover:-translate-y-2 hover:shadow-2xl
                    transition-all duration-300">

            <!-- IMAGE -->
            <?php if($f['image']): ?>

                <img src="/uploads/<?= $f['image']; ?>"
                     class="w-full h-52 object-cover">

            <?php else: ?>

                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30"
                     class="w-full h-52 object-cover">

            <?php endif; ?>

            <div class="p-5">

                <!-- TITLE -->
                <h2 class="text-2xl font-bold mb-2">

                    <?= esc($f['title']); ?>

                </h2>

                <!-- LOCATION -->
                <p class="text-gray-600 mb-2">

                    📍 <?= esc($f['location']); ?>

                </p>

                <!-- DATE -->
                <p class="text-gray-500 mb-5">

                    📅 <?= esc($f['date']); ?>

                </p>

                <!-- BUTTON -->
                <div class="flex gap-3">

                    <a href="/event/<?= $f['event_id']; ?>"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">

                       Detail

                    </a>

                    <a href="/favorite/remove/<?= $f['event_id']; ?>"
                       onclick="return confirmDelete(event)"
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                       Remove

                    </a>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

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