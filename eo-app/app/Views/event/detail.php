<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - Elevate</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition duration-300 flex flex-col min-h-screen">

    <?= view('layout/navbar'); ?>

    <main class="container mx-auto p-4 md:p-6 lg:px-24 space-y-6 flex-grow mt-4 mb-10">

        <a href="javascript:history.back()" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 font-semibold inline-flex items-center gap-2 transition transform hover:-translate-x-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Acara
        </a>

        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">

            <div class="relative w-full h-[350px] md:h-[450px]">
                <?php if($event['image']): ?>
                    <img src="/uploads/<?= esc($event['image'], 'url') ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30" class="w-full h-full object-cover filter grayscale-[30%]">
                <?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            </div>

            <div class="p-6 md:p-10 -mt-20 relative z-10">
                
                <div class="bg-white dark:bg-gray-900 p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 mb-8">
                    <?php if(isset($event['category_name'])): ?>
                        <span class="inline-block bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                            <?= esc($event['category_name']); ?>
                        </span>
                    <?php endif; ?>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight tracking-tight">
                        <?= esc($event['title']) ?>
                    </h1>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider dark:text-gray-400 mb-1">Lokasi</p>
                        <a href="http://maps.google.com/?q=<?= urlencode($event['location']) ?>" target="_blank" class="font-bold text-sm md:text-base text-gray-800 dark:text-white hover:text-blue-600 transition flex items-center gap-1">
                            <?= esc($event['location']) ?> <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-gray-400"></i>
                        </a>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-building-ngo"></i>
                        </div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider dark:text-gray-400 mb-1">Penyelenggara</p>
                        <p class="font-bold text-sm md:text-base text-gray-800 dark:text-white line-clamp-1">
                            <?= esc($event['organizer_name'] ?? 'Admin') ?>
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider dark:text-gray-400 mb-1">Tanggal Acara</p>
                        <p class="font-bold text-sm md:text-base text-gray-800 dark:text-white">
                            <?= esc($event['date']) ?>
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider dark:text-gray-400 mb-1">Harga Tiket</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-white">
                            <?= ($event['price'] > 0) ? 'Rp ' . number_format($event['price'], 0, ',', '.') : 'Gratis'; ?>
                        </p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider dark:text-gray-400 mb-1">Sisa Kuota</p>
                        <p class="font-bold text-lg <?= ($remainingSeat <= 5) ? 'text-red-600 animate-pulse' : 'text-gray-800 dark:text-white' ?>">
                            <?= esc($remainingSeat) ?> Orang
                        </p>
                    </div>
                </div> 
                
                <?php 
                    $nama_user = session()->get('name') ?? "Calon Peserta";
                    $raw_phone = $event['organizer_phone'] ?? '';
                    $clean_phone = preg_replace('/[^0-9]/', '', $raw_phone);
                    $no_wa = (strpos($clean_phone, '0') === 0) ? '62' . substr($clean_phone, 1) : $clean_phone;

                    $pesan_teks = "Halo " . $event['organizer_name'] . ",\nSaya ingin mendaftar ke event *" . $event['title'] . "*.\n\nData Peserta:\n- Nama: " . $nama_user . "\n- Status: Booking Baru\n\nMohon informasinya mengenai:\n1. Prosedur pembayaran (DANA: " . $raw_phone . ")\n2. Ketentuan pengiriman bukti transfer.\n\nTerima kasih.";
                ?>
                <a href="https://wa.me/<?= $no_wa ?>?text=<?= urlencode($pesan_teks) ?>" target="_blank" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-4 rounded-xl font-bold transition shadow-lg mb-6">
                    <i class="fa-brands fa-whatsapp text-xl"></i> Konfirmasi DANA & Tanya via WhatsApp
                </a>

                <div class="rounded-xl p-4 mb-8 flex items-center justify-between border <?= ($isBooked && $bookingStatus !== 'rejected') ? 'bg-emerald-50 border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800/50' : (($isBooked && $bookingStatus == 'rejected') ? 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800/50' : 'bg-gray-50 border-gray-200 dark:bg-gray-800/50 dark:border-gray-700') ?>">
                    <span class="text-gray-600 dark:text-gray-400 font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-info"></i> Status Registrasi Anda:
                    </span>
                    <?php if($isBooked && $bookingStatus == 'approved'): ?>
                        <span class="font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 px-4 py-1.5 rounded-lg flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-check"></i> Sudah Terdaftar
                        </span>
                    <?php elseif($isBooked && $bookingStatus == 'pending'): ?>
                        <span class="font-bold text-amber-700 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/50 px-4 py-1.5 rounded-lg flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-clock"></i> Menunggu Verifikasi
                        </span>
                    <?php elseif($isBooked && $bookingStatus == 'rejected'): ?>
                        <span class="font-bold text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/50 px-4 py-1.5 rounded-lg flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-xmark"></i> Pendaftaran Ditolak
                        </span>
                    <?php else: ?>
                        <span class="font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 px-4 py-1.5 rounded-lg shadow-sm text-sm">
                            Belum Terdaftar
                        </span>
                    <?php endif; ?>
                </div>

                <div class="mb-10">
                    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-blue-500"></i> Tentang Acara Ini
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-loose">
                        <p><?= nl2br(esc($event['description'])) ?></p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row flex-wrap gap-4 pt-8 border-t border-gray-100 dark:border-gray-800">
                    <?php 
                    $currentUserId = session()->get('id');
                    $userRole = session()->get('role');
                    $isOwner = ($currentUserId && $currentUserId == $event['owner_id']);
                    
                    if($currentUserId && $userRole != 'admin' && !$isOwner): 
                    ?>
                        <?php if((!$isBooked || $bookingStatus == 'rejected') && $remainingSeat > 0): ?>
                            <a href="/book/<?= $event['id'] ?>" class="flex-1 sm:flex-none text-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-2">
                                <i class="fa-solid fa-ticket"></i> <?= ($bookingStatus == 'rejected') ? 'Pesan Ulang Tiket' : 'Pesan Tiket Sekarang' ?>
                            </a>
                        <?php elseif((!$isBooked || $bookingStatus == 'rejected') && $remainingSeat <= 0): ?>
                            <button disabled class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-gray-300 dark:bg-gray-800 text-gray-500 dark:text-gray-500 px-8 py-4 rounded-xl font-bold cursor-not-allowed">
                                <i class="fa-solid fa-ban"></i> Tiket Habis
                            </button>
                        <?php else: ?>
                            <div class="flex-1 sm:flex-none flex items-center justify-center gap-2 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 px-8 py-4 rounded-xl font-bold border border-emerald-200 dark:border-emerald-800">
                                <i class="fa-solid <?= ($bookingStatus == 'pending') ? 'fa-hourglass-half' : 'fa-circle-check' ?>"></i> 
                                <?= ($bookingStatus == 'pending') ? 'Tiket Sedang Diproses' : 'Tiket Anda Sudah Tersimpan' ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!$isFavorite): ?>
                            <a href="/favorite/add/<?= $event['id'] ?>" class="flex-1 sm:flex-none text-center bg-white dark:bg-gray-800 hover:bg-pink-50 dark:hover:bg-pink-900/20 text-gray-700 dark:text-gray-200 hover:text-pink-600 dark:hover:text-pink-400 border border-gray-200 dark:border-gray-700 hover:border-pink-300 px-8 py-4 rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2 group">
                                <i class="fa-regular fa-heart group-hover:fa-solid group-hover:scale-110 transition-transform"></i> Simpan ke Wishlist
                            </a>
                        <?php else: ?>
                            <a href="/favorite/remove/<?= $event['id'] ?>" class="flex-1 sm:flex-none text-center bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-600 dark:hover:text-gray-400 border border-pink-200 dark:border-pink-800 px-8 py-4 rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2 group">
                                <i class="fa-solid fa-heart-crack group-hover:scale-110 transition-transform"></i> Hapus dari Wishlist
                            </a>
                        <?php endif; ?>

                    <?php elseif(!$currentUserId): ?>
                        <a href="/login" class="w-full bg-gray-800 dark:bg-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600 text-white px-8 py-4 rounded-xl text-center font-bold shadow-md transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk untuk Memesan Tiket
                        </a>
                    <?php else: ?>
                        <div class="w-full bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-500 border border-amber-200 dark:border-amber-800/50 p-4 rounded-xl font-medium text-center flex items-center justify-center gap-2">
                            <i class="fa-solid fa-eye"></i> Mode Tinjauan <?= ucfirst($userRole) ?>. Transaksi pendaftaran dinonaktifkan.
                        </div>
                    <?php endif; ?>
                </div>
                
            </div> 
        </div> <div class="bg-white dark:bg-gray-900 shadow-xl rounded-3xl p-6 md:p-10 border border-gray-100 dark:border-gray-800 mt-6">
            <h2 class="text-2xl font-bold mb-8 text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-regular fa-comments text-blue-500"></i> Diskusi Acara
            </h2>
            
            <?php if($currentUserId && $userRole == 'user' && !$isOwner): ?>
                <form action="/comment/store/<?= $event['id']; ?>" method="post" class="mb-10">
                    <div class="relative">
                        <textarea name="comment" rows="3" placeholder="Tuliskan pertanyaan atau tanggapan Anda di sini..." class="w-full border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-5 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-white transition shadow-inner" required></textarea>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition-colors shadow-md flex items-center gap-2">
                            <i class="fa-regular fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </div>
                </form>
            <?php elseif(!$currentUserId): ?>
                <div class="bg-gray-50 text-gray-600 dark:bg-gray-800 dark:text-gray-400 p-4 rounded-xl mb-8 font-medium text-center border border-dashed border-gray-300 dark:border-gray-700">
                    <i class="fa-solid fa-lock mr-2"></i> Masuk (Login) terlebih dahulu untuk bergabung dalam diskusi.
                </div>
            <?php else: ?>
                <div class="bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-500 p-4 rounded-xl mb-8 font-medium text-center text-sm border border-amber-200 dark:border-amber-800/50">
                    <i class="fa-solid fa-shield-halved mr-2"></i> Hak Akses Moderasi: Anda dapat menghapus komentar yang melanggar menggunakan ikon tempat sampah di sebelah kanan setiap komentar.
                </div>
            <?php endif; ?>

            <div class="space-y-4">
                <?php if (empty($comments)): ?>
                    <div class="text-center py-12 bg-gray-50 dark:bg-gray-800/30 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700">
                        <i class="fa-regular fa-comment-dots text-4xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada diskusi. Jadilah yang pertama bertanya!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $c): ?>
                        <div class="bg-gray-50 dark:bg-gray-800/40 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 transition duration-300 relative group hover:bg-white dark:hover:bg-gray-800 hover:shadow-md">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-br from-blue-500 to-purple-500 rounded-full w-10 h-10 flex items-center justify-center text-white font-bold shadow-sm">
                                        <?= strtoupper(substr($c['user_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                            <?= esc($c['user_name']) ?>
                                            <?php $roleBadge = $c['user_role'] ?? 'user'; ?>
                                            <?php if($roleBadge == 'admin'): ?>
                                                <i class="fa-solid fa-certificate text-red-500 text-xs" title="Admin"></i>
                                            <?php elseif($roleBadge == 'organizer'): ?>
                                                <i class="fa-solid fa-circle-check text-blue-500 text-xs" title="Organizer"></i>
                                            <?php endif; ?>
                                        </span>
                                        <span class="text-xs text-gray-400 block mt-0.5">
                                            <?= date('d M Y, H:i', strtotime($c['created_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <?php 
                                $isCommentOwner = (session()->get('id') == $c['user_id']);
                                $isAdmin = (session()->get('role') == 'admin');
                                $isEventOrganizer = (session()->get('id') == $event['owner_id']);
                                
                                if($isCommentOwner || $isAdmin || $isEventOrganizer): 
                                ?>
                                    <a href="/comment/delete/<?= $c['id']; ?>" class="delete-comment-btn text-gray-300 hover:text-red-500 dark:text-gray-600 dark:hover:text-red-500 transition-colors cursor-pointer p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20" title="Hapus Komentar">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 ml-13 pl-1 leading-relaxed">
                                <?= esc($c['comment']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main> 

    <?= view('layout/footer'); ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll('.delete-comment-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    const url = this.getAttribute('href');

                    Swal.fire({
                        title: 'Hapus Diskusi?',
                        text: "Komentar ini akan dihapus secara permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: '<i class="fa-solid fa-trash-can mr-2"></i> Ya, hapus!',
                        cancelButtonText: 'Batal',
                        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827',
                        customClass: {
                            confirmButton: 'rounded-xl',
                            cancelButton: 'rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>