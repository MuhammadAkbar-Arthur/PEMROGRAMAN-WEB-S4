<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\CategoryModel;

class Event extends BaseController
{
    public function index()
    {
        $this->checkLogin();

        $db = \Config\Database::connect();

        $builder = $db->table('events');

        $builder->select('events.*, categories.name as category_name');

        $builder->join(
            'categories',
            'categories.id = events.category_id',
            'left'
        );

        $data['events'] = $builder->get()->getResultArray();

        return view('event/index', $data);
    }

    public function create()
    {
        $this->checkLogin();

        $categoryModel = new CategoryModel();

        $data['categories'] = $categoryModel->findAll();

        return view('event/create', $data);
    }

    public function store()
    {
        $this->checkLogin();

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
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $model = new EventModel();

        $file = $this->request->getFile('image');

        $fileName = null;

        if ($file && $file->isValid()) {

            $fileName = $file->getRandomName();

            $file->move('uploads/', $fileName);
        }

        $model->save([

            'title'       => $this->request->getPost('title'),

            'description' => $this->request->getPost('description'),

            'date'        => $this->request->getPost('date'),

            'location'    => $this->request->getPost('location'),

            'category_id' => $this->request->getPost('category_id'),

            'quota'       => $this->request->getPost('quota'),

            'image'       => $fileName

        ]);

        return redirect()->to('/event')
            ->with(
                'success',
                'Event berhasil dibuat 🎉'
            );
    }

    public function edit($id)
    {
        $this->checkLogin();

        $model = new EventModel();

        $categoryModel = new CategoryModel();

        $data['event'] = $model->find($id);

        $data['categories'] = $categoryModel->findAll();

        return view('event/edit', $data);
    }

    public function update($id)
    {
        $this->checkLogin();

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
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $model = new EventModel();

        $event = $model->find($id);

        $file = $this->request->getFile('image');

        $fileName = $event['image'];

        if ($file && $file->isValid()) {

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
            ->with(
                'success',
                'Event berhasil diupdate 🎉'
            );
    }

    public function delete($id)
    {
        $this->checkLogin();

        $model = new EventModel();

        $model->delete($id);

        return redirect()->to('/event')
            ->with('success', 'Event berhasil dihapus');
    }
}