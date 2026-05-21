<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->checkLogin();

        $db = \Config\Database::connect();
        $userId = session()->get('id');
        $userRole = session()->get('role');

        // =========================
        // STATISTICS: DEFAULT GLOBAL VALUES
        // =========================
        $totalEvents = $db->table('events')
            ->countAllResults();

        $totalUsers = $db->table('users')
            ->where('role', 'user')
            ->countAllResults();

        $totalBookings = $db->table('bookings')
            ->countAllResults();

        $totalApproved = $db->table('bookings')
            ->where('status', 'approved')
            ->countAllResults();

        $totalRejected = $db->table('bookings')
            ->where('status', 'rejected')
            ->countAllResults();

        // =========================
        // PREPARE BUILDERS FOR CHARTS
        // =========================
        $chartBuilder  = $db->table('bookings');
        $statusBuilder = $db->table('bookings');

        // =========================
        // ORGANIZER MODE FILTER ENGINE
        // =========================
        if ($userRole == 'organizer') {

            $totalEvents = $db->table('events')
                ->where('owner_id', $userId)
                ->countAllResults();

            $totalBookings = $db->table('bookings')
                ->join('events', 'events.id = bookings.event_id')
                ->where('events.owner_id', $userId)
                ->countAllResults();

            $totalApproved = $db->table('bookings')
                ->join('events', 'events.id = bookings.event_id')
                ->where('events.owner_id', $userId)
                ->where('bookings.status', 'approved')
                ->countAllResults();

            $totalRejected = $db->table('bookings')
                ->join('events', 'events.id = bookings.event_id')
                ->where('events.owner_id', $userId)
                ->where('bookings.status', 'rejected')
                ->countAllResults();

            // Sinkronisasi data Chart agar hanya membaca milik Organizer
            $chartBuilder->join('events', 'events.id = bookings.event_id')
                ->where('events.owner_id', $userId);

            $statusBuilder->join('events', 'events.id = bookings.event_id')
                ->where('events.owner_id', $userId);
        }

        // =========================
        // PROCESS DATA: MONTHLY ANALYTICS CHART
        // =========================
        $chartBuilder->select("
            DATE_FORMAT(bookings.created_at, '%M') as month,
            COUNT(bookings.id) as total
        ");
        $chartBuilder->groupBy("MONTH(bookings.created_at)");
        $chartBuilder->orderBy("MONTH(bookings.created_at)", "ASC");

        $result = $chartBuilder->get()->getResultArray();

        $chartLabels = [];
        $chartData   = [];

        foreach ($result as $r) {
            $chartLabels[] = $r['month'];
            $chartData[]   = $r['total'];
        }

        // =========================
        // PROCESS DATA: STATUS ANALYTICS CHART
        // =========================
        $statusBuilder->select("
            bookings.status,
            COUNT(bookings.id) as total
        ");
        $statusBuilder->groupBy('bookings.status');

        $statusResult = $statusBuilder->get()->getResultArray();

        $statusLabels = [];
        $statusData   = [];

        foreach ($statusResult as $s) {
            $statusLabels[] = ucfirst($s['status']);
            $statusData[]   = $s['total'];
        }

        // =========================
        // CONTENT DATA: UPCOMING EVENTS & WISHLIST FOR USER VIEW
        // =========================
        // Menarik data Booking Aktif milik User saat ini
        $upcoming = $db->table('bookings')
            ->select('events.*, bookings.status as booking_status')
            ->join('events', 'events.id = bookings.event_id')
            ->where('bookings.user_id', $userId)
            ->orderBy('events.date', 'ASC')
            ->limit(3)
            ->get()
            ->getResultArray();

        // =========================
        // TOP EVENT PERFORMANCE
        // =========================

        $topEventBuilder = $db->table('bookings');

        $topEventBuilder->select('
            events.id,
            events.title,
            events.image,
            COUNT(bookings.id) as total_booking
        ');

        $topEventBuilder->join(
            'events',
            'events.id = bookings.event_id'
        );

        // FILTER ORGANIZER
        if ($userRole == 'organizer') {

            $topEventBuilder->where(
                'events.owner_id',
                $userId
            );
        }

        $topEventBuilder->groupBy('events.id');

        $topEventBuilder->orderBy(
            'total_booking',
            'DESC'
        );

        $topEventBuilder->limit(5);

        $topEvents = $topEventBuilder
            ->get()
            ->getResultArray();
        // =========================
        // LATEST BOOKINGS
        // =========================

        $latestBookingBuilder = $db->table('bookings');

        $latestBookingBuilder->select('
            bookings.id,
            bookings.status,
            bookings.created_at,
            users.name as user_name,
            events.title as event_title
        ');

        $latestBookingBuilder->join(
            'users',
            'users.id = bookings.user_id'
        );

        $latestBookingBuilder->join(
            'events',
            'events.id = bookings.event_id'
        );

        // FILTER ORGANIZER
        if ($userRole == 'organizer') {

            $latestBookingBuilder->where(
                'events.owner_id',
                $userId
            );
        }

        $latestBookingBuilder->orderBy(
            'bookings.id',
            'DESC'
        );

        $latestBookingBuilder->limit(5);

        $latestBookings = $latestBookingBuilder
            ->get()
            ->getResultArray();
        // =========================
        // LATEST USERS
        // =========================

        $latestUserBuilder = $db->table('users');

        $latestUserBuilder->select('
            id,
            name,
            email,
            role,
            created_at
        ');

        $latestUserBuilder->orderBy(
            'id',
            'DESC'
        );

        $latestUserBuilder->limit(5);

        $latestUsers = $latestUserBuilder
            ->get()
            ->getResultArray();
        // =========================
        // RETURN VIEW WITH COMPLETE SYNCED DATA
        // =========================
        return view('dashboard/index', [
            // Statistik Angka Utama
            'totalEvents'   => $totalEvents,
            'totalUsers'    => $totalUsers,
            'totalBookings' => $totalBookings,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
            
            // Komponen Data List Card
            'upcoming'      => $upcoming,
            
            // Komponen Data Grafik Analytics (Sudah berformat string JSON)
            'chartLabels'   => json_encode($chartLabels),
            'chartData'     => json_encode($chartData),
            'statusLabels'  => json_encode($statusLabels),
            'statusData'    => json_encode($statusData),

            'topEvents'      => $topEvents,
            'latestBookings' => $latestBookings,
            'latestUsers'    => $latestUsers,
        ]);
    }
}