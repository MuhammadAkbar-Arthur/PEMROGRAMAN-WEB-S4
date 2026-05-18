<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $user_id = session()->get('id');

        // TOTAL BOOKING
        $bookingTotal = $db->table('bookings')
            ->where('user_id', $user_id)
            ->countAllResults();

        // TOTAL FAVORITE
        $favoriteTotal = $db->table('favorites')
            ->where('user_id', $user_id)
            ->countAllResults();

        // UPCOMING EVENT
        $upcoming = $db->table('bookings')
            ->select('events.*')
            ->join('events', 'events.id = bookings.event_id')
            ->where('bookings.user_id', $user_id)
            ->orderBy('events.date', 'ASC')
            ->limit(3)
            ->get()
            ->getResultArray();

        // RECENT FAVORITE
        $favorites = $db->table('favorites')
            ->select('events.*')
            ->join('events', 'events.id = favorites.event_id')
            ->where('favorites.user_id', $user_id)
            ->orderBy('favorites.id', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();

        return view('dashboard/index', [

            'bookingTotal' => $bookingTotal,
            'favoriteTotal' => $favoriteTotal,
            'upcoming' => $upcoming,
            'favorites' => $favorites

        ]);
    }
}