<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\BookingModel;
use App\Models\FavoriteModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function bantuan()
    {
        // Memanggil file bantuan.php yang ada di folder Views
        return view('bantuan');
    }
    public function index()
    {
        $model = new EventModel();

        // JOIN CATEGORY
        $model->select('events.*, categories.name as category_name');
        $model->join('categories', 'categories.id = events.category_id', 'left');

        // GET FILTER
        $keyword  = $this->request->getGet('keyword');
        $location = $this->request->getGet('location');
        $category = $this->request->getGet('category');
        $sort     = $this->request->getGet('sort');

        // SEARCH TITLE
        if (!empty($keyword)) {
            $model->like('events.title', $keyword);
        }

        // SEARCH LOCATION
        if (!empty($location)) {
            $model->like('events.location', $location);
        }

        // FILTER CATEGORY
        if (!empty($category)) {
            $model->where('events.category_id', $category);
        }

        // SORTING
        if ($sort == 'oldest') {
            $model->orderBy('events.date', 'ASC');
        } else {
            $model->orderBy('events.date', 'DESC');
        }

        // PAGINATION
        $data['events'] = $model->findAll();

        // CATEGORY DATA
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        // FILTER VALUE
        $data['keyword']  = $keyword;
        $data['location'] = $location;
        $data['category'] = $category;
        $data['sort']     = $sort;

        return view('home', $data);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();

        // ==========================================
        // 1. AMBIL DATA EVENT (JOIN CATEGORIES & USERS)
        // ==========================================
        $builder = $db->table('events');
        $builder->select('events.*, categories.name as category_name, users.name as organizer_name, users.phone as organizer_phone');
        $builder->join('categories', 'categories.id = events.category_id', 'left');
        $builder->join('users', 'users.id = events.owner_id', 'left'); // JOIN KE USERS
        $builder->where('events.id', $id);
        $event = $builder->get()->getRowArray();

        if (!$event) {
            return redirect()->to('/')->with('error', 'Event tidak ditemukan.');
        }

        $data['event'] = $event;

        // ==========================================
        // 2. HITUNG SISA KUOTA
        // ==========================================
        $bookingModel = new BookingModel();
        
        $totalBooked = $bookingModel->where('event_id', $id)
                                    ->where('status', 'approved')
                                    ->countAllResults();

        $data['totalBooked']   = $totalBooked;
        $data['remainingSeat'] = $event['quota'];
        $data['isFull']        = $event['quota'] <= 0;

        // ==========================================
        // 3. CEK STATUS USER (BOOKING & WISHLIST)
        // ==========================================
        $user_id = session()->get('id');

        // DEFAULT
        $data['isBooked']   = false;
        $data['isFavorite'] = false;
        $data['bookingStatus'] = null; // Tambahkan variabel ini

        if ($user_id) {
            // CEK BOOKING
            $checkBooking = $bookingModel->where('user_id', $user_id)
                                         ->where('event_id', $id)
                                         ->first();
            if ($checkBooking) {
                $data['isBooked'] = true;
                $data['bookingStatus'] = $checkBooking['status']; // Ambil statusnya (pending/approved/rejected)
            }

            // CEK FAVORITE
            $favoriteModel = new FavoriteModel();
            $favoriteCheck = $favoriteModel->where('user_id', $user_id)
                                           ->where('event_id', $id)
                                           ->first();
            if ($favoriteCheck) {
                $data['isFavorite'] = true;
            }
        }

        // ==========================================
        // 4. LOAD COMMENTS
        // ==========================================
        $commentBuilder = $db->table('comments');
        $commentBuilder->select('comments.*, users.name as user_name, users.role as user_role');
        
        $commentBuilder->join('users', 'users.id = comments.user_id');
        $commentBuilder->where('comments.event_id', $id);
        $commentBuilder->orderBy('comments.id', 'DESC');

        $data['comments'] = $commentBuilder->get()->getResultArray();
            
        return view('event/detail', $data);
    }

    public function search()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('events');

        $builder->select('events.*, categories.name as category_name');
        $builder->join('categories', 'categories.id = events.category_id', 'left');

        $keyword  = $this->request->getGet('keyword');
        $location = $this->request->getGet('location');
        $category = $this->request->getGet('category');
        $sort     = $this->request->getGet('sort');

        if (!empty($keyword)) {
            $builder->like('events.title', $keyword);
        }
        if (!empty($location)) {
            $builder->like('events.location', $location);
        }
        if (!empty($category)) {
            $builder->where('events.category_id', $category);
        }
        if ($sort == 'oldest') {
            $builder->orderBy('events.date', 'ASC');
        } else {
            $builder->orderBy('events.date', 'DESC');
        }

        $events = $builder->get()->getResultArray();

        return $this->response->setJSON($events);
    }
}