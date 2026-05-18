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

        if ($file && $file->isValid()) {

            $avatarName = $file->getRandomName();

            $file->move('uploads/', $avatarName);
        }

        $data = [

            'name' => $this->request->getPost('name'),

            'phone' => $this->request->getPost('phone'),

            'bio' => $this->request->getPost('bio'),

            'avatar' => $avatarName
        ];

        // update password jika diisi
        if ($this->request->getPost('password')) {

            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $model->update($id, $data);

        session()->set('name', $data['name']);

        return redirect()->to('/profile')
            ->with('success', 'Profile berhasil diupdate');
    }
}