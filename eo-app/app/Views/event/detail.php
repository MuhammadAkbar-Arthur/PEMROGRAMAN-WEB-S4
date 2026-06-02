<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class'
    }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition duration-300">

<?= view('layout/navbar'); ?>

<div class="container mx-auto p-4 md:p-6 space-y-6">

    <a href="javascript:history.back()" class="text-blue-500 hover:text-blue-700 font-semibold inline-block transition transform hover:-translate-x-1">
        ← Kembali
    </a>

    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl overflow-hidden">

        <?php if($event['image']): ?>
            <img src="/uploads/<?= esc($event['image'], 'url') ?>" class="w-full h-[400px] object-cover">
        <?php else: ?>
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-[400px] object-cover">
        <?php endif; ?>

        <div class="p-6 md:p-8">

            <?php if(isset($event['category_name'])): ?>
                <span class="bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 px-4 py-1 rounded-full text-sm font-medium">
                    <?= esc($event['category_name']); ?>
                </span>
            <?php endif; ?>

            <h1 class="text-3xl md:text-4xl font-bold mt-4 mb-4 text-gray-800 dark:text-white">
                <?= esc($event['title']) ?>
            </h1>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Location</p>
                    <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($event['location']) ?>" 
                       target="_blank" 
                       class="font-bold text-base md:text-lg text-blue-500 hover:underline">
                        📍 <?= esc($event['location']) ?> 🔗
                    </a>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Organizer</p>
                    <p class="font-bold text-base md:text-lg">
                        👤 <?= esc($event['organizer_name'] ?? 'Admin') ?>
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Event Date</p>
                    <p class="font-bold text-base md:text-lg">
                        📅 <?= esc($event['date']) ?>
                    </p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-4 border-l-4 border-blue-500">
                    <p class="text-gray-500 text-sm dark:text-gray-400">Sisa Slot</p>
                    <p class="font-bold text-base md:text-lg text-blue-600 dark:text-blue-400">
                        🔥 <?= $remainingSeat; ?> Slot
                    </p>
                </div>

            </div>

            <div class="bg-gray-50 dark:bg-gray-800/40 rounded-xl p-4 mb-6 flex items-center justify-between">
                <span class="text-gray-600 dark:text-gray-400 font-medium">Status Registrasi:</span>
                <?php if($isBooked): ?>
                    <span class="font-bold text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-lg">✔ Already Booked</span>
                <?php else: ?>
                    <span class="font-bold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-3 py-1 rounded-lg">Available</span>
                <?php endif; ?>
            </div>

            <div class="mb-8 border-t border-gray-100 dark:border-gray-800 pt-6">
                <h2 class="text-2xl font-bold mb-3 text-gray-800 dark:text-white">About Event</h2>
                <p class="text-gray-700 dark:text-gray-200 leading-8"><?= esc($event['description']) ?></p>
            </div>

            <div class="flex flex-wrap gap-4 items-center border-t border-gray-100 dark:border-gray-800 pt-6">
                <?php 
                $currentUserId = session()->get('id');
                $userRole = session()->get('role');
                $isOwner = ($currentUserId && $currentUserId == $event['owner_id']);
                
                // TAMPILKAN TOMBOL HANYA JIKA: Sudah Login + Bukan Admin + Bukan Pemilik Event
                if($currentUserId && $userRole != 'admin' && !$isOwner): 
                ?>
                    <?php if(!$isBooked && $remainingSeat > 0): ?>
                        <a href="/book/<?= $event['id'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all transform active:scale-[0.98]">🎟 Book Now</a>
                    <?php elseif(!$isBooked && $remainingSeat <= 0): ?>
                        <button disabled class="bg-gray-400 dark:bg-gray-700 text-gray-200 px-8 py-4 rounded-xl cursor-not-allowed">❌ Sold Out</button>
                    <?php else: ?>
                        <div class="bg-green-100 text-green-700 dark:bg-green-900/30 px-6 py-4 rounded-xl font-semibold">✔ Kamu sudah booking event ini</div>
                    <?php endif; ?>
                    
                    <?php if(!$isFavorite): ?>
                        <a href="/favorite/add/<?= $event['id'] ?>" class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all">❤️ Add Wishlist</a>
                    <?php else: ?>
                        <a href="/favorite/remove/<?= $event['id'] ?>" class="bg-gray-700 hover:bg-gray-800 text-white px-8 py-4 rounded-xl inline-block text-lg font-semibold shadow-lg transition-all">❌ Remove Wishlist</a>
                    <?php endif; ?>

                <?php elseif(!$currentUserId): ?>
                    <a href="/login" class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl w-full md:w-auto text-center font-semibold">Login untuk Booking</a>
                    
                <?php else: ?>
                    <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 px-6 py-4 rounded-xl font-medium w-full text-center">
                        👋 Mode Tinjauan <?= ucfirst($userRole) ?> (Aksi pendaftaran tiket dinonaktifkan untuk Anda)
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-6 md:p-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">💬 Discussion</h2>
        
        <?php 
        $currentUserId = session()->get('id');
        $userRole = session()->get('role');
        $isOwner = ($currentUserId && $currentUserId == $event['owner_id']);
        
        // HANYA USER BIASA YANG BISA MENULIS KOMENTAR BARU
        if($currentUserId && $userRole == 'user' && !$isOwner): 
        ?>
            <form action="/comment/store/<?= $event['id']; ?>" method="post" class="mb-8">
                <textarea name="comment" rows="4" placeholder="Tulis komentar..." class="w-full border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 rounded-xl mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-white" required></textarea>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-medium transition-colors">Kirim Komentar</button>
            </form>
        <?php elseif(!$currentUserId): ?>
            <div class="bg-red-50 text-red-700 dark:bg-red-900/20 p-4 rounded-xl mb-6 font-medium">Login untuk ikut diskusi</div>
        <?php else: ?>
            <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 p-4 rounded-xl mb-6 font-medium text-center">
                Moderasi Komentar: Anda dapat menghapus komentar yang tidak pantas menggunakan ikon 🗑️ di sebelah kanan komentar.
            </div>
        <?php endif; ?>

        <div class="space-y-4">
        <?php if (empty($comments)): ?>
            <div class="text-center py-8 text-gray-500 dark:text-gray-400 italic">
                Belum ada diskusi. Jadilah yang pertama berkomentar!
            </div>
        <?php else: ?>
            <?php foreach ($comments as $c): ?>
                <div class="bg-gray-50 dark:bg-gray-800/40 p-5 rounded-xl border border-gray-100 dark:border-gray-800 transition duration-300 relative group">
                    <div class="flex justify-between items-start mb-2">
                        <span class="font-bold text-gray-800 dark:text-white flex items-center gap-2">
                            <div class="bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 rounded-full w-8 h-8 flex items-center justify-center text-sm">
                                <?= substr($c['user_name'], 0, 1) ?>
                            </div>
                            <?= esc($c['user_name']) ?>
                            <?php $roleBadge = $c['user_role'] ?? 'user'; ?>
                            <?php if($roleBadge == 'admin'): ?>
                                <span class="ml-2 text-[10px] font-bold bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-400 px-2 py-0.5 rounded-full">
                                    Admin
                                </span>
                            <?php elseif($roleBadge == 'organizer'): ?>
                                <span class="ml-2 text-[10px] font-bold bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400 px-2 py-0.5 rounded-full">
                                    Organizer
                                </span>
                            <?php endif; ?>
                        </span>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                <?= date('d M Y, H:i', strtotime($c['created_at'])) ?>
                            </span>
                            
                            <?php 
                            // LOGIKA HAK AKSES HAPUS KOMENTAR
                            $isCommentOwner = (session()->get('id') == $c['user_id']);
                            $isAdmin = (session()->get('role') == 'admin');
                            $isEventOrganizer = (session()->get('id') == $event['owner_id']);
                            
                            if($isCommentOwner || $isAdmin || $isEventOrganizer): 
                            ?>
                                <a href="/comment/delete/<?= $c['id']; ?>" class="delete-comment-btn text-red-500 hover:text-red-700 transition opacity-0 group-hover:opacity-100 cursor-pointer" title="Hapus Komentar">
                                    🗑️
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 ml-10">
                        <?= esc($c['comment']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
        
    </div>
</div> 
<?= view('layout/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('body').on('click', '.delete-comment-btn', function(e) {
        e.preventDefault(); 
        const url = $(this).attr('href');

        Swal.fire({
            title: 'Hapus Komentar?',
            text: "Komentar ini akan dihapus permanen.",
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
</script>
</body>
</html>