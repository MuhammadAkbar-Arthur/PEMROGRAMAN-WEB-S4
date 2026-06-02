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
        // Cegah user yang sudah login masuk ke halaman login lagi
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('role'));
        }

        return view('login');
    }

    // =========================
    // PROCESS LOGIN
    // =========================
    public function processLogin()
    {
        helper(['form']);

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        $model = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah');
        }

        // VALIDASI ROLE
        $allowedRoles = ['admin', 'organizer', 'user'];
        if (!in_array($user['role'], $allowedRoles)) {
            return redirect()->back()->with('error', 'Role akun tidak valid');
        }

        // REGENERATE SESSION (Security Update)
        session()->regenerate();

        // SET SESSION
        session()->set([
            'id'        => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        session()->setFlashdata('success', 'Login berhasil 🎉');

        // Arahkan ke dashboard masing-masing
        return $this->redirectBasedOnRole($user['role']);
    }

    // =========================
    // REGISTER PAGE
    // =========================
    public function register()
    {
        // Cegah user yang sudah login masuk ke halaman register
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('role'));
        }

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
                'rules'  => 'required|min_length[3]',
                'errors' => ['required' => 'Nama wajib diisi', 'min_length' => 'Nama minimal 3 karakter']
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => ['required' => 'Email wajib diisi', 'valid_email' => 'Format email tidak valid', 'is_unique' => 'Email sudah digunakan']
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => ['required' => 'Password wajib diisi', 'min_length' => 'Password minimal 6 karakter']
            ],
            'confirm_password' => [
                'rules'  => 'matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak sama']
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();

        $model->save([
            'name'     => strip_tags(trim($this->request->getPost('name'))),
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user'
        ]);

        return redirect()->to('/login')->with('success', 'Register berhasil. Silakan login!');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        // Hapus spesifik key agar Flashdata tetap bisa berjalan di CI4
        session()->remove(['id', 'name', 'email', 'role', 'logged_in']);
        
        return redirect()->to('/login')->with('success', 'Logout berhasil 👋');
    }

    // =========================
    // HELPER METHOD (PRIVATE)
    // =========================
    private function redirectBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/admin');
        } elseif ($role === 'organizer') {
            return redirect()->to('/organizer');
        }
        return redirect()->to('/');
    }
}