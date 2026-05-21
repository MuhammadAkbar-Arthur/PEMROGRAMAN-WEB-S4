<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\CategoryModel;

class Event extends BaseController
{
    public function __construct()
    {
        // 1. Pastikan user wajib terautentikasi (Login check)
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->send();
        }

        // 2. Proteksi Akses: Tolak user dengan role peserta biasa
        if (session()->get('role') === 'user') {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut!')->send();
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('events');
        $builder->select('events.*, categories.name as category_name');
        $builder->join('categories', 'categories.id = events.category_id', 'left');

        // SINKRONISASI SEGREGASI DATA: Filter berdasarkan role pemilik
        if (session()->get('role') === 'organizer') {
            $builder->where('events.owner_id', session()->get('id'));
        }

        $data['events'] = $builder->get()->getResultArray();

        return view('event/index', $data);
    }

    public function create()
    {
        // 1. PROTEKSI ROLE: Hanya Admin dan Organizer yang bisa masuk ke form create
        if (
            session()->get('role') != 'admin' &&
            session()->get('role') != 'organizer'
        ) {
            return redirect()->to('/');
        }

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('event/create', $data);
    }

    public function store()
    {
        // 1. PROTEKSI ROLE: Amankan juga method pengiriman data (store) dari bypass URL
        if (
            session()->get('role') != 'admin' &&
            session()->get('role') != 'organizer'
        ) {
            return redirect()->to('/');
        }

        helper(['form']);

        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Judul event wajib diisi',
                    'min_length' => 'Judul minimal 3 karakter'
                ]
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi wajib diisi'
                ]
            ],
            'date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal wajib diisi'
                ]
            ],
            'location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi wajib diisi'
                ]
            ],
            'category_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category wajib dipilih'
                ]
            ],
            'quota' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Kuota wajib diisi',
                    'integer' => 'Kuota harus angka',
                    'greater_than' => 'Kuota minimal 1'
                ]
            ],
            'image' => [
                'rules' => 'uploaded[image]|max_size[image,2048]|is_image[image]',
                'errors' => [
                    'uploaded' => 'Gambar event wajib diupload',
                    'max_size' => 'Ukuran gambar maksimal 2MB',
                    'is_image' => 'File harus berupa gambar'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new EventModel();
        $file = $this->request->getFile('image');
        $fileName = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/', $fileName);
        }

        // 2. PROSES INSERT DATABASE + PENGIKATAN OWNER
        // Sesuai validasi Login, pastikan menggunakan session()->get('id') atau session()->get('user_id')
        $model->save([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'location'    => $this->request->getPost('location'),
            'category_id' => $this->request->getPost('category_id'),
            'quota'       => $this->request->getPost('quota'),
            'image'       => $fileName,
            'owner_id'    => session()->get('id') // Hubungkan langsung dengan id pengelola yang login
        ]);

        return redirect()->to('/event')
            ->with('success', 'Event berhasil dibuat 🎉');
    }

    public function edit($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')
                ->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER CHECK (Mencegah manipulasi ID via URL browser)
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')
                ->with('error', 'Anda tidak memiliki hak akses untuk mengubah event milik orang lain!');
        }

        $categoryModel = new CategoryModel();
        $data['event'] = $event;
        $data['categories'] = $categoryModel->findAll();

        return view('event/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);

        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Judul event wajib diisi',
                    'min_length' => 'Judul minimal 3 karakter'
                ]
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi wajib diisi'
                ]
            ],
            'date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal wajib diisi'
                ]
            ],
            'location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi wajib diisi'
                ]
            ],
            'category_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category wajib dipilih'
                ]
            ],
            'quota' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Kuota wajib diisi',
                    'integer' => 'Kuota harus angka',
                    'greater_than' => 'Kuota minimal 1'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')
                ->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER UPDATE SECURITY
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')
                ->with('error', 'Anda tidak berhak memperbarui event ini!');
        }

        $file = $this->request->getFile('image');
        $fileName = $event['image'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/', $fileName);
        }

        $model->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'location'    => $this->request->getPost('location'),
            'category_id' => $this->request->getPost('category_id'),
            'quota'       => $this->request->getPost('quota'),
            'image'       => $fileName
        ]);

        return redirect()->to('/event')
            ->with('success', 'Event berhasil diupdate 🎉');
    }

    public function delete($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')
                ->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER DELETE SECURITY
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')
                ->with('error', 'Anda tidak diizinkan menghapus event milik pihak lain!');
        }

        $model->delete($id);

        return redirect()->to('/event')
            ->with('success', 'Event berhasil dihapus 🗑');
    }
}