<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserManagement extends BaseController
{
    public function index()
    {
        if(session()->get('role') != 'admin'){
            return redirect()->to('/');
        }

        $model = new UserModel();

        $users = $model->findAll();

        return view('admin/users', [
            'users' => $users
        ]);
    }

    public function makeOrganizer($id)
    {
        if(session()->get('role') != 'admin'){
            return redirect()->to('/');
        }

        $model = new UserModel();

        $model->update($id, [
            'role' => 'organizer'
        ]);

        return redirect()->back()
            ->with('success', 'User berhasil dijadikan organizer');
    }

    public function makeUser($id)
    {
        if(session()->get('role') != 'admin'){
            return redirect()->to('/');
        }

        $model = new UserModel();

        $model->update($id, [
            'role' => 'user'
        ]);

        return redirect()->back()
            ->with('success', 'Organizer berhasil dijadikan user');
    }
}