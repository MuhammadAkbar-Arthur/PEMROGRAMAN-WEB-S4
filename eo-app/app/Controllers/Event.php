<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\CategoryModel;

class Event extends BaseController
{
    // Fungsi bantuan untuk menentukan arah redirect agar tidak nyasar
    private function getRedirectUrl() 
    {
        return (session()->get('role') === 'admin') ? '/event' : '/organizer/my-events';
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('events');
        // Tambahkan join ke users untuk mengambil nama organizer
        $builder->select('events.*, categories.name as category_name, users.name as organizer_name');
        $builder->join('categories', 'categories.id = events.category_id', 'left');
        $builder->join('users', 'users.id = events.owner_id', 'left'); 

        if (session()->get('role') === 'organizer') {
            $builder->where('events.owner_id', session()->get('id'));
        }

        $builder->orderBy('events.id', 'DESC');
        $data['events'] = $builder->get()->getResultArray();

        return view('event/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin' && session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('event/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'admin' && session()->get('role') != 'organizer') {
            return redirect()->to('/');
        }

        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'required',
            'date'        => 'required',
            'location'    => 'required',
            'category_id' => 'required',
            'quota'       => 'required|integer|greater_than[0]',
            'image'       => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new EventModel();
        $file = $this->request->getFile('image');
        $fileName = 'default.jpg'; // Default jika file gagal

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        }

        $model->save([
            'title'       => trim($this->request->getPost('title')),
            'description' => trim($this->request->getPost('description')),
            'date'        => $this->request->getPost('date'),
            'location'    => trim($this->request->getPost('location')),
            'category_id' => $this->request->getPost('category_id'),
            'quota'       => $this->request->getPost('quota'),
            'image'       => $fileName,
            'owner_id'    => session()->get('id')
        ]);

        return redirect()->to($this->getRedirectUrl())->with('success', 'Event berhasil dibuat 🎉');
    }

    public function edit($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) return redirect()->to($this->getRedirectUrl())->with('error', 'Event tidak ditemukan');

        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to($this->getRedirectUrl())->with('error', 'Akses ditolak!');
        }

        $data['event'] = $event;
        $data['categories'] = (new CategoryModel())->findAll();

        return view('event/edit', $data);
    }

    public function update($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) return redirect()->to($this->getRedirectUrl())->with('error', 'Event tidak ditemukan');

        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to($this->getRedirectUrl())->with('error', 'Akses ditolak!');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required',
            'date' => 'required',
            'location' => 'required',
            'category_id' => 'required',
            'quota' => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $fileName = $event['image'];
        $file = $this->request->getFile('image');

        if ($file && $file->isValid()) {
            if ($fileName !== 'default.jpg' && file_exists(FCPATH . 'uploads/' . $fileName)) {
                unlink(FCPATH . 'uploads/' . $fileName);
            }
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        }

        $model->update($id, [
            'title'       => trim($this->request->getPost('title')),
            'description' => trim($this->request->getPost('description')),
            'date'        => $this->request->getPost('date'),
            'location'    => trim($this->request->getPost('location')),
            'category_id' => $this->request->getPost('category_id'),
            'quota'       => $this->request->getPost('quota'),
            'image'       => $fileName
        ]);

        return redirect()->to($this->getRedirectUrl())->with('success', 'Event berhasil diupdate 🎉');
    }

    public function delete($id)
    {
        $model = new EventModel();
        $event = $model->find($id);
        if (!$event) return redirect()->to($this->getRedirectUrl())->with('error', 'Event tidak ditemukan');
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to($this->getRedirectUrl())->with('error', 'Akses ditolak!');
        }
        if ($event) {
            if ($event['image'] !== 'default.jpg' && file_exists(FCPATH . 'uploads/' . $event['image'])) {
                unlink(FCPATH . 'uploads/' . $event['image']);
            }
            $model->delete($id);
            return redirect()->to($this->getRedirectUrl())->with('success', 'Event berhasil dihapus 🗑');
        }
        return redirect()->to($this->getRedirectUrl())->with('error', 'Event tidak ditemukan');
    }
}