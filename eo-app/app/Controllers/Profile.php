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

        // upload avatar
        $file = $this->request->getFile('avatar');

        $avatarName = $user['avatar'];
        // VALIDASI AVATAR
        $allowedMimeTypes = [

            'image/png',
            'image/jpeg',
            'image/jpg',
            'image/webp'

        ];

        if ($file && $file->isValid()) {

            // CEK MIME
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {

                return redirect()->back()
                    ->with(
                        'error',
                        'Avatar harus berupa gambar'
                    );
            }

            // CEK SIZE (2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {

                return redirect()->back()
                    ->with(
                        'error',
                        'Ukuran avatar maksimal 2MB'
                    );
            }
        }
        if ($file && $file->isValid()) {

            $avatarName = $file->getRandomName();

            // HAPUS AVATAR LAMA
            if (
                $user['avatar'] &&
                file_exists('uploads/' . $user['avatar'])
            ) {

                unlink('uploads/' . $user['avatar']);
            }

            $file->move('uploads/', $avatarName);
        }

        $data = [

            'name' => $this->request->getPost('name'),

            'phone' => $this->request->getPost('phone'),

            'bio' => $this->request->getPost('bio'),

            'avatar' => $avatarName
        ];

        // update password jika diisi
        $password = $this->request->getPost('password');

        $confirmPassword = $this->request->getPost('confirm_password');

        // update password jika diisi
        if ($password) {

            if ($password !== $confirmPassword) {

                return redirect()->back()
                    ->with(
                        'error',
                        'Konfirmasi password tidak sama'
                    );
            }

            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }
        // VALIDASI PHONE
        if (
            $data['phone'] &&
            !preg_match('/^[0-9+\-\s]+$/', $data['phone'])
        ) {

            return redirect()->back()
                ->with(
                    'error',
                    'Format nomor HP tidak valid'
                );
        }
        // LIMIT BIO
        if (strlen($data['bio']) > 300) {

            return redirect()->back()
                ->with(
                    'error',
                    'Bio maksimal 300 karakter'
                );
        }
        $model->update($id, $data);

        session()->set('name', $data['name']);

        return redirect()->to('/profile')
            ->with('success', 'Profile berhasil diupdate');
    }
}