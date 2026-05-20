<!DOCTYPE html>
<html>
<head>

    <title>My Bookings</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<script>

function confirmDelete(event)
{
    event.preventDefault();

    const url = event.currentTarget.href;

    Swal.fire({

        title: 'Yakin?',
        text: 'Booking akan dibatalkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Ya, Batalkan'

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

            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">
                🎫 My Bookings
            </h1>

            <p class="text-gray-500 mt-2">
                Semua booking event kamu ada di sini
            </p>

        </div>

        <a href="/"
           class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl shadow">

           ← Back Home

        </a>

    </div>

    <!-- EMPTY -->
    <?php if(empty($bookings)): ?>

        <div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-10 text-center">

            <h2 class="text-3xl font-bold mb-3 text-gray-800 dark:text-white">

                Belum ada booking 😢

            </h2>

            <p class="text-gray-500 mb-6">

                Yuk booking event favoritmu sekarang

            </p>

            <a href="/"
               class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl">

               Explore Event

            </a>

        </div>

    <?php else: ?>

    <!-- TABLE -->
    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-200 dark:bg-gray-800">

                <tr>

                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Event</th>
                    <th class="p-4 text-left">Date</th>
                    <th class="p-4 text-left">Location</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>

                </tr>

            </thead>

            <tbody>

                <?php $no = 1; ?>

                <?php foreach($bookings as $b): ?>

                <tr class="border-b dark:border-gray-700">

                    <td class="p-4">

                        <?= $no++; ?>

                    </td>

                    <td class="p-4 font-semibold">

                        <?= esc($b['title']); ?>

                    </td>

                    <td class="p-4">

                        <?= esc($b['date']); ?>

                    </td>

                    <td class="p-4">

                        📍 <?= esc($b['location']); ?>

                    </td>

                    <td class="p-4">

                        <?php if($b['status'] == 'pending'): ?>

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">

                                Pending

                            </span>

                        <?php elseif($b['status'] == 'approved'): ?>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                Approved

                            </span>

                        <?php elseif($b['status'] == 'rejected'): ?>

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                Rejected

                            </span>

                        <?php endif; ?>

                    </td>

                    <td class="p-4">

                        <div class="flex gap-2">

                            <?php if($b['status'] == 'approved'): ?>

                                <a href="/ticket/<?= $b['id'] ?>"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">

                                    Ticket

                                </a>

                            <?php else: ?>

                                <button
                                    class="bg-gray-400 text-white px-3 py-1 rounded cursor-not-allowed"
                                    disabled>

                                    Ticket Locked

                                </button>

                            <?php endif; ?>

                            <a href="/booking/delete/<?= $b['id']; ?>"
                               onclick="return confirmDelete(event)"
                               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">

                               Cancel

                            </a>

                        </div>

                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <?php endif; ?>

</div>

<?= view('layout/footer'); ?>

<?php if(session()->getFlashdata('success')): ?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil 🎉',

    text: '<?= esc(session()->getFlashdata('success')); ?>',

    confirmButtonColor: '#2563eb'

});

</script>

<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>

<script>

Swal.fire({

    icon: 'error',

    title: 'Oops 😢',

    text: '<?= esc(session()->getFlashdata('error')); ?>',

    confirmButtonColor: '#dc2626'

});

</script>

<?php endif; ?>

</body>
</html>