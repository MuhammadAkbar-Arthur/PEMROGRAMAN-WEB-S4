<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $user = $model->find(session()->get('id'));

        // PERBAIKAN DI SINI: Arahkan kembali ke 'profile/index'
        return view('profile/index', [ 
            'user' => $user
        ]);
    }

    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $id = session()->get('id');
        $user = $model->find($id);

        $data = [
            'name'  => trim($this->request->getPost('name')),
            'phone' => trim($this->request->getPost('phone')),
            'bio'   => trim($this->request->getPost('bio')),
            'avatar'=> $user['avatar'] // Default gunakan avatar lama
        ];

        // Validasi Dasar
        if (empty($data['name'])) {
            return redirect()->back()->with('error', 'Nama tidak boleh kosong');
        }

        // =========================
        // UPLOAD AVATAR
        // =========================
        $file = $this->request->getFile('avatar');
        
        if ($file && $file->isValid()) {
            $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

            // CEK MIME
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                return redirect()->back()->with('error', 'Avatar harus berupa gambar (PNG/JPG/WEBP)');
            }

            // CEK SIZE (Maks 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran avatar maksimal 2MB');
            }

            $avatarName = $file->getRandomName();

            // HAPUS AVATAR LAMA
            if ($user['avatar'] && file_exists(FCPATH . 'uploads/' . $user['avatar'])) {
                unlink(FCPATH . 'uploads/' . $user['avatar']);
            }

            // PINDAHKAN AVATAR BARU
            $file->move(FCPATH . 'uploads/', $avatarName);
            $data['avatar'] = $avatarName;
        }

        // =========================
        // UPDATE PASSWORD
        // =========================
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!empty($password)) {
            if ($password !== $confirmPassword) {
                return redirect()->back()->with('error', 'Konfirmasi password tidak sama');
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // =========================
        // VALIDASI FORMAT
        // =========================
        if (!empty($data['phone']) && !preg_match('/^[0-9+\-\s]+$/', $data['phone'])) {
            return redirect()->back()->with('error', 'Format nomor HP tidak valid');
        }

        if (strlen($data['bio']) > 300) {
            return redirect()->back()->with('error', 'Bio maksimal 300 karakter');
        }

        // =========================
        // SIMPAN KE DATABASE
        // =========================
        $model->update($id, $data);
        session()->set('name', $data['name']);

        return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate 🎉');
    }
}