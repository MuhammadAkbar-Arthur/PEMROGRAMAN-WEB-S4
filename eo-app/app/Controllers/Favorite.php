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
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new FavoriteModel();

        $user_id = session()->get('id');

        // cek duplicate
        $check = $model
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        if (!$check) {

            $model->save([

                'user_id' => $user_id,
                'event_id' => $event_id

            ]);
        }

        return redirect()->back()
            ->with('success', 'Event ditambahkan ke wishlist');
    }

    // =========================
    // REMOVE FAVORITE
    // =========================
    public function remove($event_id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $model = new FavoriteModel();

        $user_id = session()->get('id');

        $favorite = $model
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->first();

        if ($favorite) {

            $model->delete($favorite['id']);
        }

        return redirect()->back()
            ->with('success', 'Wishlist berhasil dihapus');
    }

    // =========================
    // MY FAVORITES
    // =========================
    public function index()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $builder = $db->table('favorites');

        $builder->select('favorites.*, events.title, events.image, events.date, events.location');

        $builder->join(
            'events',
            'events.id = favorites.event_id'
        );

        $builder->where(
            'favorites.user_id',
            session()->get('id')
        );

        $data['favorites'] = $builder
            ->get()
            ->getResultArray();

        return view('favorite/index', $data);
    }
}