<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold">
            Event List
        </h1>

        <div class="flex gap-2">

            <a href="/event/create"
               class="bg-green-500 text-white px-4 py-2 rounded">
               + Tambah Event
            </a>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-900 shadow rounded p-6">

        <table class="w-full">

            <thead class="bg-gray-200">

                <tr>

                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Location</th>
                    <th class="p-3 text-left">Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php $no=1; foreach($events as $e): ?>

                <tr class="border-b">

                    <td class="p-3">
                        <?= $no++ ?>
                    </td>

                    <td class="p-3">
                        <?= $e['title'] ?>
                    </td>

                    <td class="p-3">
                        <?= $e['date'] ?>
                    </td>

                    <td class="p-3">
                        <?= $e['location'] ?>
                    </td>

                    <td class="p-3 flex gap-2">

                        <a href="/event/edit/<?= $e['id'] ?>"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                           Edit
                        </a>

                        <a href="/event/delete/<?= $e['id'] ?>"
                            onclick="return confirmDelete(event)"
                            class="delete-btn text-red-500">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<script>

const deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(button => {

    button.addEventListener('click', function(e) {

        e.preventDefault();

        const url = this.getAttribute('href');

        Swal.fire({

            title: 'Yakin?',
            text: "Data event akan dihapus!",
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',

            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = url;

            }

        });

    });

});

</script>
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