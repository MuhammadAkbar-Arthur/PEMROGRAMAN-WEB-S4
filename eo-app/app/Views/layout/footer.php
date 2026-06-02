<?php
$isLoggedIn = session()->get('logged_in');
$role = session()->get('role');
?>
<footer class="bg-gray-950 text-gray-300 mt-16 border-t border-gray-800">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

            <div>
                <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400 mb-4 tracking-tight">
                    EO Management.
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Platform ekosistem booking event modern untuk seminar, konser, workshop, dan berbagai acara akademik maupun hiburan.
                </p>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4 text-white">Quick Navigation</h2>
                <ul class="space-y-3 text-sm text-gray-400">
                    
                    <?php if(!$isLoggedIn): ?>
                        <li><a href="/" class="hover:text-blue-400 transition">➔ Home</a></li>
                        <li><a href="/login" class="hover:text-blue-400 transition">➔ Login</a></li>
                        <li><a href="/register" class="hover:text-blue-400 transition">➔ Register</a></li>
                    
                    <?php elseif($role == 'user'): ?>
                        <li><a href="/" class="hover:text-blue-400 transition">➔ Home</a></li>
                        <li><a href="/favorite" class="hover:text-pink-400 transition">➔ Wishlist</a></li>
                        <li><a href="/my-bookings" class="hover:text-blue-400 transition">➔ My Booking</a></li>
                        <li><a href="/profile" class="hover:text-amber-400 transition">➔ Profile</a></li>
                    
                    <?php elseif($role == 'organizer'): ?>
                        <li><a href="/organizer" class="hover:text-blue-400 transition">➔ Organizer Dashboard</a></li>
                        <li><a href="/organizer/my-events" class="hover:text-emerald-400 transition">➔ My Events</a></li>
                        <li><a href="/event/create" class="hover:text-indigo-400 transition">➔ Create Event</a></li>
                        <li><a href="/organizer/bookings" class="hover:text-purple-400 transition">➔ Manage Bookings</a></li>
                        <li><a href="/profile" class="hover:text-amber-400 transition">➔ Profile</a></li>
                    
                    <?php elseif($role == 'admin'): ?>
                        <li><a href="/admin" class="hover:text-amber-400 transition">➔ Admin Dashboard</a></li>
                        <li><a href="/event" class="hover:text-emerald-400 transition">➔ Kelola Event</a></li>
                        <li><a href="/admin/users" class="hover:text-blue-400 transition">➔ Kelola User</a></li>
                        <li><a href="/admin/categories" class="hover:text-purple-400 transition">➔ Kelola Category</a></li>
                        <li><a href="/admin/analytics" class="hover:text-pink-400 transition">➔ Analytics</a></li>
                    <?php endif; ?>

                </ul>
            </div>

            <div>
                <h2 class="text-lg font-semibold mb-4 text-white">Contact Information</h2>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <span class="text-lg">📍</span>
                        <span>Mataram, West Nusa Tenggara<br>Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-lg">📧</span>
                        <a href="mailto:support@event.com" class="hover:text-white transition">support@event.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-lg">📞</span>
                        <span>+62 812 3456 7890</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-xs text-gray-500 flex flex-col md:flex-row justify-between items-center gap-4">
            <p>© <?= date('Y') ?> EO Management System. All rights reserved.</p>
            <p>Developed for Final Project (Web Programming & APBO)</p>
        </div>
    </div>
</footer>

<script>
<?php if(session()->getFlashdata('success')): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: <?= json_encode(session()->getFlashdata('success')); ?>,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    });
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: <?= json_encode(session()->getFlashdata('error')); ?>,
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#f9fafb' : '#111827'
    });
<?php endif; ?>
</script>