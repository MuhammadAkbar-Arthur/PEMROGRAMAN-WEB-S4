<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\CategoryModel;

class Event extends BaseController
{
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

        // Urutkan dari event terbaru
        $builder->orderBy('events.id', 'DESC');

        $data['events'] = $builder->get()->getResultArray();

        return view('event/index', $data);
    }

    public function create()
    {
        // PROTEKSI ROLE: Hanya Admin dan Organizer yang bisa masuk ke form create
        if (session()->get('role') != 'admin' && session()->get('role') != 'organizer') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        return view('event/create', $data);
    }

    public function store()
    {
        // PROTEKSI ROLE
        if (session()->get('role') != 'admin' && session()->get('role') != 'organizer') {
            return redirect()->to('/');
        }

        $rules = [
            'title'       => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul event wajib diisi', 'min_length' => 'Judul minimal 3 karakter']],
            'description' => ['rules' => 'required', 'errors' => ['required' => 'Deskripsi wajib diisi']],
            'date'        => ['rules' => 'required', 'errors' => ['required' => 'Tanggal wajib diisi']],
            'location'    => ['rules' => 'required', 'errors' => ['required' => 'Lokasi wajib diisi']],
            'category_id' => ['rules' => 'required', 'errors' => ['required' => 'Category wajib dipilih']],
            'quota'       => ['rules' => 'required|integer|greater_than[0]', 'errors' => ['required' => 'Kuota wajib diisi', 'integer' => 'Kuota harus angka', 'greater_than' => 'Kuota minimal 1']],
            'image'       => [
                'rules' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Gambar event wajib diupload',
                    'max_size' => 'Ukuran gambar maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format gambar tidak valid'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new EventModel();
        $file = $this->request->getFile('image');
        $fileName = null;

        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        }

        // PROSES INSERT DATABASE + PENGIKATAN OWNER
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

        return redirect()->to('/event')->with('success', 'Event berhasil dibuat 🎉');
    }

    public function edit($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER CHECK SECURITY
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')->with('error', 'Anda tidak memiliki hak akses untuk mengubah event milik orang lain!');
        }

        $categoryModel = new CategoryModel();
        $data['event'] = $event;
        $data['categories'] = $categoryModel->findAll();

        return view('event/edit', $data);
    }

    public function update($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER UPDATE SECURITY
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')->with('error', 'Anda tidak berhak memperbarui event ini!');
        }

        $rules = [
            'title'       => ['rules' => 'required|min_length[3]', 'errors' => ['required' => 'Judul event wajib diisi', 'min_length' => 'Judul minimal 3 karakter']],
            'description' => ['rules' => 'required', 'errors' => ['required' => 'Deskripsi wajib diisi']],
            'date'        => ['rules' => 'required', 'errors' => ['required' => 'Tanggal wajib diisi']],
            'location'    => ['rules' => 'required', 'errors' => ['required' => 'Lokasi wajib diisi']],
            'category_id' => ['rules' => 'required', 'errors' => ['required' => 'Category wajib dipilih']],
            'quota'       => ['rules' => 'required|integer|greater_than[0]', 'errors' => ['required' => 'Kuota wajib diisi', 'integer' => 'Kuota harus angka', 'greater_than' => 'Kuota minimal 1']],
        ];

        // Validasi gambar HANYA JIKA user mengunggah file baru
        $file = $this->request->getFile('image');
        if ($file && $file->isValid()) {
            $rules['image'] = [
                'rules' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format gambar tidak valid'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileName = $event['image']; // Default pakai foto lama

        // Proses jika ada foto baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);

            // Bersihkan storage: Hapus foto lama jika ada
            if ($event['image'] && file_exists(FCPATH . 'uploads/' . $event['image'])) {
                unlink(FCPATH . 'uploads/' . $event['image']);
            }
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

        return redirect()->to('/event')->with('success', 'Event berhasil diupdate 🎉');
    }

    public function delete($id)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return redirect()->to('/event')->with('error', 'Event tidak ditemukan');
        }

        // VALIDASI OWNER DELETE SECURITY
        if (session()->get('role') === 'organizer' && $event['owner_id'] != session()->get('id')) {
            return redirect()->to('/event')->with('error', 'Anda tidak diizinkan menghapus event milik pihak lain!');
        }

        // Bersihkan storage: Hapus gambar event sebelum datanya dihapus
        if ($event['image'] && file_exists(FCPATH . 'uploads/' . $event['image'])) {
            unlink(FCPATH . 'uploads/' . $event['image']);
        }

        $model->delete($id);

        // Optional: Hapus juga tiket booking atau komentar yang terkait event ini (bisa ditambahkan nanti jika perlu)

        return redirect()->to('/event')->with('success', 'Event berhasil dihapus 🗑');
    }
}