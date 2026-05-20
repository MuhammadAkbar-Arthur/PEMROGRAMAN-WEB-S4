<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\BookingModel;
use App\Models\FavoriteModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new EventModel();

        // JOIN CATEGORY
        $model->select('events.*, categories.name as category_name');

        $model->join(
            'categories',
            'categories.id = events.category_id',
            'left'
        );

        // GET FILTER
        $keyword   = $this->request->getGet('keyword');
        $location  = $this->request->getGet('location');
        $category  = $this->request->getGet('category');
        $sort      = $this->request->getGet('sort');

        // SEARCH TITLE
        if ($keyword) {

            $model->like('events.title', $keyword);

        }

        // SEARCH LOCATION
        if ($location) {

            $model->like('events.location', $location);

        }

        // FILTER CATEGORY
        if ($category) {

            $model->where('events.category_id', $category);

        }

        // SORTING
        if ($sort == 'oldest') {

            $model->orderBy('events.date', 'ASC');

        } else {

            $model->orderBy('events.date', 'DESC');

        }

        // PAGINATION
        $data['events'] = $model->paginate(6);

        $data['pager'] = $model->pager;

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

        // EVENT + CATEGORY
        $builder = $db->table('events');

        $builder->select('events.*, categories.name as category_name');

        $builder->join(
            'categories',
            'categories.id = events.category_id',
            'left'
        );

        $builder->where('events.id', $id);

        $event = $builder->get()->getRowArray();

        // kalau event tidak ada
        if (!$event) {

            return redirect()->to('/');
        }

        $data['event'] = $event;
        $bookingModel = new \App\Models\BookingModel();
        // TOTAL BOOKING APPROVED
        $totalBooked = $bookingModel
            ->where('event_id', $id)
            ->where('status', 'approved')
            ->countAllResults();

        $data['totalBooked'] = $totalBooked;

        // SISA KURSI
        $data['remainingSeat'] = $event['quota'] - $totalBooked;

        // FULL EVENT
        $data['isFull'] = $totalBooked >= $event['quota'];

        $bookingModel = new BookingModel();

        $user_id = session()->get('id');

        // DEFAULT
        $data['isBooked'] = false;
        $data['isFavorite'] = false;

        // CEK BOOKING
        if ($user_id) {

            $checkBooking = $bookingModel
                ->where('user_id', $user_id)
                ->where('event_id', $id)
                ->first();

            if ($checkBooking) {

                $data['isBooked'] = true;
            }

            // CEK FAVORITE
            $favoriteModel = new FavoriteModel();

            $favoriteCheck = $favoriteModel
                ->where('user_id', $user_id)
                ->where('event_id', $id)
                ->first();

            if ($favoriteCheck) {

                $data['isFavorite'] = true;
            }
        }
        // COMMENTS
        $commentBuilder = $db->table('comments');

        $commentBuilder->select('comments.*, users.name');

        $commentBuilder->join(
            'users',
            'users.id = comments.user_id'
        );

        $commentBuilder->where('comments.event_id', $id);

        $commentBuilder->orderBy('comments.id', 'DESC');

        $data['comments'] = $commentBuilder
            ->get()
            ->getResultArray();
            
        return view('event/detail', $data);
    }
    public function search()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('events');

        $builder->select('events.*, categories.name as category_name');

        $builder->join(
            'categories',
            'categories.id = events.category_id',
            'left'
        );

        $keyword  = $this->request->getGet('keyword');
        $location = $this->request->getGet('location');
        $category = $this->request->getGet('category');
        $sort     = $this->request->getGet('sort');

        // SEARCH TITLE
        if ($keyword) {

            $builder->like('events.title', $keyword);

        }

        // LOCATION
        if ($location) {

            $builder->like('events.location', $location);

        }

        // CATEGORY
        if ($category) {

            $builder->where('events.category_id', $category);

        }

        // SORT
        if ($sort == 'oldest') {

            $builder->orderBy('events.date', 'ASC');

        } else {

            $builder->orderBy('events.date', 'DESC');

        }

        $events = $builder->get()->getResultArray();

        return $this->response->setJSON($events);
    }
}