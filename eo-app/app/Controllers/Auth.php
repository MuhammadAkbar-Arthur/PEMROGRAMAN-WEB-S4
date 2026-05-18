<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // =========================
    // LOGIN PAGE
    // =========================
    public function login()
    {
        return view('login');
    }

    // =========================
    // PROCESS LOGIN
    // =========================
    public function processLogin()
    {
        $validation = \Config\Services::validation();

        $rules = [

            'email' => 'required|valid_email',

            'password' => 'required|min_length[6]'

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('error', $validation->listErrors());
        }

        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {

            if (password_verify($password, $user['password'])) {

                session()->set([
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role'],
                    'logged_in' => true
                ]);

                session()->setFlashdata(
                    'success',
                    'Login berhasil 🎉'
                );

                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin');
                }

                return redirect()->to('/');
            }
        }

        return redirect()->to('/login')
            ->withInput()
            ->with('error', 'Email atau password salah');
    }

    // =========================
    // REGISTER PAGE
    // =========================
    public function register()
    {
        return view('register');
    }

    // =========================
    // PROCESS REGISTER
    // =========================
    public function processRegister()
    {
        helper(['form']);

        $rules = [

            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama wajib diisi',
                    'min_length' => 'Nama minimal 3 karakter'
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],

            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        $model->save([

            'name' => $this->request->getPost('name'),

            'email' => $this->request->getPost('email'),

            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),

            'role' => 'user'

        ]);

        return redirect()->to('/login')
            ->with('success', 'Register berhasil');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}