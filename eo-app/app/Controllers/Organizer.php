<?php

namespace App\Controllers;

class Organizer extends BaseController
{
    public function index()
    {
        $this->checkLogin();

        if(session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses organizer ditolak');
        }

        $db = \Config\Database::connect();
        $userId = session()->get('id');

        // =========================
        // FILTER RANGE TANGGAL (BARU)
        // =========================
        $range = $this->request->getGet('range') ?? 'month';

        // default condition
        $dateCondition = "";

        if ($range == 'today') {
            $dateCondition = "DATE(bookings.created_at) = CURDATE()";
        } elseif ($range == 'week') {
            $dateCondition = "bookings.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } else {
            $dateCondition = "MONTH(bookings.created_at) = MONTH(CURDATE())
                              AND YEAR(bookings.created_at) = YEAR(CURDATE())";
        }

        // TOTAL EVENT
        $totalEvents = $db->table('events')->where('owner_id', $userId)->countAllResults();

        // TOTAL BOOKING
        $totalBookings = $db->table('bookings')
            ->join('events', 'events.id = bookings.event_id')
            ->where('events.owner_id', $userId)
            ->countAllResults();

        // APPROVED
        $totalApproved = $db->table('bookings')
            ->join('events', 'events.id = bookings.event_id')
            ->where('events.owner_id', $userId)
            ->where('bookings.status', 'approved')
            ->countAllResults();

        // REJECTED
        $totalRejected = $db->table('bookings')
            ->join('events', 'events.id = bookings.event_id')
            ->where('events.owner_id', $userId)
            ->where('bookings.status', 'rejected')
            ->countAllResults();

        // UPCOMING EVENTS
        $upcoming = $db->table('events')
            ->where('owner_id', $userId)
            ->orderBy('date', 'ASC')
            ->limit(3)
            ->get()
            ->getResultArray();

        // =========================
        // CHART DATA (SUDAH FILTER)
        // =========================
        $chartQuery = $db->query("
            SELECT MONTH(bookings.created_at) as month, COUNT(*) as total
            FROM bookings
            JOIN events ON events.id = bookings.event_id
            WHERE events.owner_id = $userId
            AND $dateCondition
            GROUP BY MONTH(bookings.created_at)
            ORDER BY MONTH(bookings.created_at)
        ")->getResultArray();

        $chartLabels = [];
        $chartData = [];

        foreach($chartQuery as $c){
            $chartLabels[] = date('F', mktime(0,0,0,$c['month'],1));
            $chartData[] = $c['total'];
        }

        // STATUS CHART
        $statusQuery = $db->query("
            SELECT bookings.status, COUNT(*) as total
            FROM bookings
            JOIN events ON events.id = bookings.event_id
            WHERE events.owner_id = $userId
            GROUP BY bookings.status
        ")->getResultArray();

        $statusLabels = [];
        $statusData = [];

        foreach($statusQuery as $s){
            $statusLabels[] = ucfirst($s['status']);
            $statusData[] = $s['total'];
        }

        return view('organizer/dashboard', [
            'totalEvents' => $totalEvents,
            'totalBookings' => $totalBookings,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
            'upcoming' => $upcoming,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($chartData),
            'statusLabels' => json_encode($statusLabels),
            'statusData' => json_encode($statusData),
            'range' => $range
        ]);
    }

    public function bookings()
    {
        $this->checkLogin();

        if(session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses organizer ditolak');
        }

        $db = \Config\Database::connect();
        $userId = session()->get('id');

        $bookings = $db->table('bookings')
            ->select('
                bookings.*,
                events.title,
                events.date,
                users.name,
                users.email
            ')
            ->join('events', 'events.id = bookings.event_id')
            ->join('users', 'users.id = bookings.user_id')
            ->where('events.owner_id', $userId)
            ->orderBy('bookings.id', 'DESC')
            ->get()
            ->getResultArray();

        return view('organizer/bookings', [
            'bookings' => $bookings
        ]);
    }

    public function myEvents()
    {
        $this->checkLogin();

        if(session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses organizer ditolak');
        }

        $db = \Config\Database::connect();

        $events = $db->table('events')
            ->select('events.*, categories.name as category_name')
            ->join('categories', 'categories.id = events.category_id', 'left')
            ->where('events.owner_id', session()->get('id'))
            ->orderBy('events.id', 'DESC')
            ->get()
            ->getResultArray();

        return view('organizer/my_events', [
            'events' => $events
        ]);
    }

    public function deleteBooking($id)
    {
        $this->checkLogin();

        if (session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses organizer ditolak');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('bookings');

        $booking = $builder->select('bookings.id, bookings.status, events.owner_id')
                           ->join('events', 'events.id = bookings.event_id')
                           ->where('bookings.id', $id)
                           ->get()->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Data pesanan tidak ditemukan!');
        }

        if ($booking['owner_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Akses Ilegal: Anda tidak berhak menghapus pesanan di event orang lain!');
        }

        if ($booking['status'] != 'rejected') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status DITOLAK yang dapat dihapus.');
        }

        $db->table('bookings')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Data pesanan berhasil dihapus. Peserta kini dapat mendaftar ulang.');
    }
}