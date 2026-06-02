<?php

namespace App\Controllers;

use App\Models\FavoriteModel;

class Favorite extends BaseController
{
    // =========================
    // ADD FAVORITE
    // =========================
    public function add($event_id)
    {
        // Proteksi Role: Hanya User biasa yang punya fitur Wishlist
        if (session()->get('role') != 'user') {
            return redirect()->back()->with('error', 'Fitur wishlist hanya tersedia untuk User peserta.');
        }

        $model = new FavoriteModel();
        $user_id = session()->get('id');

        // Cek duplicate
        $check = $model->where('user_id', $user_id)
                       ->where('event_id', $event_id)
                       ->first();

        if (!$check) {
            $model->save([
                'user_id'  => $user_id,
                'event_id' => $event_id
            ]);
            return redirect()->back()->with('success', 'Event ditambahkan ke wishlist ❤️');
        }

        return redirect()->back()->with('error', 'Event sudah ada di wishlist kamu.');
    }

    // =========================
    // REMOVE FAVORITE
    // =========================
    public function remove($event_id)
    {
        // Proteksi Role
        if (session()->get('role') != 'user') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $model = new FavoriteModel();
        $user_id = session()->get('id');

        $favorite = $model->where('user_id', $user_id)
                          ->where('event_id', $event_id)
                          ->first();

        if ($favorite) {
            $model->delete($favorite['id']);
            return redirect()->back()->with('success', 'Wishlist berhasil dihapus 🗑️');
        }

        return redirect()->back()->with('error', 'Data wishlist tidak ditemukan.');
    }

    // =========================
    // MY FAVORITES
    // =========================
    public function index()
    {
        // Proteksi Role
        if (session()->get('role') != 'user') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('favorites');

        $builder->select('favorites.*, events.title, events.image, events.date, events.location');
        $builder->join('events', 'events.id = favorites.event_id');
        $builder->where('favorites.user_id', session()->get('id'));

        $data['favorites'] = $builder->get()->getResultArray();

        return view('favorite/index', $data);
    }
}