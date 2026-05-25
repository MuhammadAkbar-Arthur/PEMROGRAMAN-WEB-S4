<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        // =========================
        // TOTAL STATS
        // =========================
        $data['totalUsers'] = $db->table('users')->countAllResults();
        $data['totalEvents'] = $db->table('events')->countAllResults();
        $data['totalBookings'] = $db->table('bookings')->countAllResults();
        $data['totalFavorites'] = $db->table('favorites')->countAllResults();

        // =========================
        // STATUS ANALYTICS
        // =========================
        $data['pendingCount'] = $db->table('bookings')->where('status', 'pending')->countAllResults();
        $data['approvedCount'] = $db->table('bookings')->where('status', 'approved')->countAllResults();
        $data['rejectedCount'] = $db->table('bookings')->where('status', 'rejected')->countAllResults();

        // =========================
        // DATA BOOKING TABLE
        // =========================
        $builder = $db->table('bookings');
        $builder->select('bookings.id, bookings.status, bookings.created_at, users.name as user_name, events.title as event_title, events.date, events.location');
        $builder->join('users', 'users.id = bookings.user_id');
        $builder->join('events', 'events.id = bookings.event_id');
        $builder->orderBy('bookings.id', 'DESC');
        $data['bookings'] = $builder->get()->getResultArray();

        // =========================
        // DATA ALL EVENTS TABLE (BARU - UNTUK MODERASI ADMIN)
        // =========================
        $eventBuilder = $db->table('events');
        $eventBuilder->select('events.*, users.name as organizer_name');
        $eventBuilder->join('users', 'users.id = events.owner_id', 'left');
        $eventBuilder->orderBy('events.id', 'DESC');
        $data['all_events'] = $eventBuilder->get()->getResultArray();

        // =========================
        // DATA CHART
        // =========================
        $chartBuilder = $db->table('bookings');
        $chartBuilder->select('events.title, COUNT(bookings.id) as total');
        $chartBuilder->join('events', 'events.id = bookings.event_id');
        $chartBuilder->groupBy('events.title');
        $chartData = $chartBuilder->get()->getResultArray();

        $labels = [];
        $totals = [];
        foreach ($chartData as $c) {
            $labels[] = $c['title'];
            $totals[] = $c['total'];
        }
        $data['chartLabels'] = json_encode($labels);
        $data['chartTotals'] = json_encode($totals);

        return view('admin/dashboard', $data);
    }

    // ==========================================
    // ADMIN DELETE EVENT GLOBAL (PRIORITAS 4)
    // ==========================================
    public function deleteEvent($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        
        // Cek keberadaan event
        $event = $db->table('events')->where('id', $id)->get()->getRowArray();
        if (!$event) {
            return redirect()->back()->with('error', 'Event tidak ditemukan.');
        }

        // Jalankan Database Transaction agar pembersihan aman bersilang relasi
        $db->transStart();

        // 1. Hapus seluruh data booking transaksi tiket yang masuk ke event ini
        $db->table('bookings')->where('event_id', $id)->delete();

        // 2. Hapus seluruh wishlist user yang mengarah ke event ini
        $db->table('favorites')->where('event_id', $id)->delete();

        // 3. Hapus data event utama
        $db->table('events')->where('id', $id)->delete();

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal menghapus event karena kesalahan sistem database.');
        }

        return redirect()->back()->with('success', 'Event beserta data relasi tiket berhasil dihapus oleh Admin.');
    }

    // =========================
    // EXPORT CSV
    // =========================
    public function exportCSV()
    {
        if (session()->get('role') != 'admin') {

            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('bookings');

        $builder->select('
            users.name as user_name,
            events.title as event_title,
            events.date,
            events.location,
            bookings.status
        ');

        $builder->join(
            'users',
            'users.id = bookings.user_id'
        );

        $builder->join(
            'events',
            'events.id = bookings.event_id'
        );

        $data = $builder
            ->get()
            ->getResultArray();

        // HEADER DOWNLOAD
        header('Content-Type: text/csv');

        header(
            'Content-Disposition: attachment; filename="booking_data.csv"'
        );

        $output = fopen(
            "php://output",
            "w"
        );

        // HEADER CSV
        fputcsv($output, [

            'User',
            'Event',
            'Date',
            'Location',
            'Status'

        ]);

        // DATA CSV
        foreach ($data as $row) {

            fputcsv($output, [

                $row['user_name'],
                $row['event_title'],
                $row['date'],
                $row['location'],
                $row['status']

            ]);
        }

        fclose($output);

        exit;
    }
    public function users()
    {
        if(session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $users = $db->table('users')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/users', [
            'users' => $users
        ]);
    }
    public function makeOrganizer($id)
    {
        if(session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $db->table('users')
            ->where('id', $id)
            ->update([
                'role' => 'organizer'
            ]);

        return redirect()->back()
            ->with('success', 'User berhasil dijadikan organizer');
    }
    public function makeUser($id)
    {
        if(session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        $db->table('users')
            ->where('id', $id)
            ->update([
                'role' => 'user'
            ]);

        return redirect()->back()
            ->with('success', 'Organizer berhasil dijadikan user');
    }
    // public function analytics()
    // {
    //     if(session()->get('role') != 'admin') {
    //         return redirect()->to('/');
    //     }

    //     return view('admin/analytics');
    // }
    public function analytics()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();

        // ==========================================
        // 1. ANALYTICS: BOOKING STATUS (PIE)
        // ==========================================
        $statusData = $db->query("
            SELECT status, COUNT(*) total
            FROM bookings
            GROUP BY status
        ")->getResultArray();

        $statusLabels = [];
        $statusTotals = [];

        foreach ($statusData as $row) {
            $statusLabels[] = ucfirst($row['status']);
            $statusTotals[] = (int)$row['total'];
        }

        // ==========================================
        // 2. ANALYTICS: TOP EVENTS (BAR)
        // ==========================================
        $eventData = $db->query("
            SELECT events.title,
            COUNT(bookings.id) total
            FROM events
            LEFT JOIN bookings
            ON bookings.event_id = events.id
            GROUP BY events.id
            ORDER BY total DESC
            LIMIT 5
        ")->getResultArray();

        $eventLabels = [];
        $eventTotals = [];

        foreach ($eventData as $row) {
            $eventLabels[] = $row['title'];
            $eventTotals[] = (int)$row['total'];
        }

        // ==========================================
        // 3. ANALYTICS: USER GROWTH (LINE) - BARU!
        // ==========================================
        // Mengelompokkan pendaftaran user berdasarkan Bulan (format: YYYY-MM)
        $growthData = $db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total
            FROM users
            WHERE created_at IS NOT NULL
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY month ASC
            LIMIT 12
        ")->getResultArray();

        $growthLabels = [];
        $growthTotals = [];

        foreach ($growthData as $row) {
            // Mengubah format 2026-05 menjadi nama bulan agar lebih cantik (e.g., May 2026)
            $dateObj = date_create($row['month'] . "-01");
            $growthLabels[] = date_format($dateObj, "M Y");
            $growthTotals[] = (int)$row['total'];
        }

        // Jika data growth kosong, beri fallback data dummy agar chart tidak error kosong
        if (empty($growthLabels)) {
            $growthLabels = ['No Data'];
            $growthTotals = [0];
        }

        return view('admin/analytics', [
            'statusLabels' => json_encode($statusLabels),
            'statusTotals' => json_encode($statusTotals),
            'eventLabels'  => json_encode($eventLabels),
            'eventTotals'  => json_encode($eventTotals),
            'growthLabels' => json_encode($growthLabels),
            'growthTotals' => json_encode($growthTotals),
        ]);
    }
    public function deleteUser($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/');
        }

        // PROTEKSI: Admin tidak boleh menghapus akunnya sendiri yang sedang login
        if (session()->get('id') == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan.');
        }

        $db = \Config\Database::connect();
        
        // Cek apakah user memang ada di database
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Mulai Database Transaction untuk menjaga integritas data (anti-corrupt)
        $db->transStart();

        // 1. Hapus data di tabel anak/relasi terlebih dahulu
        $db->table('bookings')->where('user_id', $id)->delete();
        $db->table('favorites')->where('user_id', $id)->delete();
        
        // 2. Jika user tersebut organizer, hapus juga bookingan yang masuk ke event miliknya agar tidak menggantung (optional cascading)
        $myEvents = $db->table('events')->where('owner_id', $id)->get()->getResultArray();
        foreach ($myEvents as $ev) {
            $db->table('bookings')->where('event_id', $ev['id'])->delete();
            $db->table('favorites')->where('event_id', $ev['id'])->delete();
        }
        // Hapus event milik organizer tersebut
        $db->table('events')->where('owner_id', $id)->delete();

        // 3. Terakhir, hapus data user utama
        $db->table('users')->where('id', $id)->delete();

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Gagal menghapus user karena masalah relasi database.');
        }

        return redirect()->back()->with('success', 'User dan seluruh data terkait berhasil dihapus permanen.');
    }
}