<footer class="bg-gray-900 text-white mt-16">

    <div class="container mx-auto px-6 py-10">

        <div class="grid md:grid-cols-3 gap-8">

            <!-- BRAND -->
            <div>

                <h2 class="text-2xl font-bold mb-3">
                    Event Organizer
                </h2>

                <p class="text-gray-400">
                    Platform booking event modern
                    untuk seminar, konser,
                    workshop, dan berbagai acara menarik lainnya.
                </p>

            </div>

            <!-- MENU -->
            <div>

                <h2 class="text-xl font-semibold mb-3">
                    Navigation
                </h2>

                <ul class="space-y-2 text-gray-400">

                    <li>
                        <a href="/" class="hover:text-white">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/event" class="hover:text-white">
                            Event
                        </a>
                    </li>

                    <li>
                        <a href="/my-bookings" class="hover:text-white">
                            Booking
                        </a>
                    </li>

                    <li>
                        <a href="/profile" class="hover:text-white">
                            Profile
                        </a>
                    </li>

                </ul>

            </div>

            <!-- CONTACT -->
            <div>

                <h2 class="text-xl font-semibold mb-3">
                    Contact
                </h2>

                <p class="text-gray-400">
                    📍 Mataram, Indonesia
                </p>

                <p class="text-gray-400">
                    📧 support@event.com
                </p>

                <p class="text-gray-400">
                    📞 +62 812 3456 7890
                </p>

            </div>

        </div>

        <div class="border-t border-gray-700 mt-8 pt-4 text-center text-gray-500">

            © <?= date('Y') ?> Event Organizer.
            All rights reserved.

        </div>

    </div>

</footer>

<!-- SWEET ALERT SESSION -->
<script>

<?php if(session()->getFlashdata('success')): ?>

Swal.fire({

    toast: true,
    position: 'top-end',
    icon: 'success',
    title: '<?= session()->getFlashdata('success') ?>',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true

});

<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>

Swal.fire({

    toast: true,
    position: 'top-end',
    icon: 'error',
    title: '<?= session()->getFlashdata('error') ?>',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true

});

<?php endif; ?>

</script>