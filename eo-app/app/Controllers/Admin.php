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

        $data['totalUsers'] = $db
            ->table('users')
            ->countAllResults();

        $data['totalEvents'] = $db
            ->table('events')
            ->countAllResults();

        $data['totalBookings'] = $db
            ->table('bookings')
            ->countAllResults();

        $data['totalFavorites'] = $db
            ->table('favorites')
            ->countAllResults();

        // =========================
        // STATUS ANALYTICS
        // =========================

        $data['pendingCount'] = $db
            ->table('bookings')
            ->where('status', 'pending')
            ->countAllResults();

        $data['approvedCount'] = $db
            ->table('bookings')
            ->where('status', 'approved')
            ->countAllResults();

        $data['rejectedCount'] = $db
            ->table('bookings')
            ->where('status', 'rejected')
            ->countAllResults();

        // =========================
        // DATA BOOKING TABLE
        // =========================

        $builder = $db->table('bookings');

        $builder->select('
            bookings.id,
            bookings.status,
            bookings.created_at,
            users.name as user_name,
            events.title as event_title,
            events.date,
            events.location
        ');

        $builder->join(
            'users',
            'users.id = bookings.user_id'
        );

        $builder->join(
            'events',
            'events.id = bookings.event_id'
        );

        $builder->orderBy(
            'bookings.id',
            'DESC'
        );

        $data['bookings'] = $builder
            ->get()
            ->getResultArray();

        // =========================
        // DATA CHART
        // =========================

        $chartBuilder = $db->table('bookings');

        $chartBuilder->select('
            events.title,
            COUNT(bookings.id) as total
        ');

        $chartBuilder->join(
            'events',
            'events.id = bookings.event_id'
        );

        $chartBuilder->groupBy(
            'events.title'
        );

        $chartData = $chartBuilder
            ->get()
            ->getResultArray();

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
}