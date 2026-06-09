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

        // Ambil input role dari form, jika tidak cocok/kosong, paksa ke default 'user'
        $inputRole = $this->request->getPost('role');
        $role = in_array($inputRole, ['user', 'organizer']) ? $inputRole : 'user';

        $model->save([
            'name'     => strip_tags(trim($this->request->getPost('name'))),
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $role
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
    // Proses saat tombol 'Kirim Link Reset' ditekan
    public function forgotPasswordProcess()
    {
        $email = $this->request->getPost('email');
        $userModel = new \App\Models\UserModel(); // Sesuaikan dengan model kamu
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // TRIK DEMO: Alih-alih kirim email asli, kita langsung buatkan sesi token 
            // dan arahkan ke halaman reset password agar dosen bisa langsung lihat alurnya.
            
            // Generate token acak (opsional, untuk keamanan)
            $token = bin2hex(random_bytes(16));
            
            // Simpan email dan token di session untuk sementara
            session()->setFlashdata('reset_email', $email);
            session()->setFlashdata('reset_token', $token);
            
            // Redirect langsung ke halaman reset password
            return redirect()->to('/reset-password');
        } else {
            return redirect()->back()->with('error', 'Alamat email tidak ditemukan dalam sistem.');
        }
    }

    // Menampilkan halaman reset password
    public function resetPassword()
    {
        // Ambil data dari flashdata yang diset tadi
        $data = [
            'email' => session()->getFlashdata('reset_email'),
            'token' => session()->getFlashdata('reset_token')
        ];

        // Jika tidak ada email dari proses sebelumnya, tendang balik ke form forgot
        if (empty($data['email'])) {
            return redirect()->to('/forgot-password')->with('error', 'Sesi reset tidak valid atau telah kadaluarsa.');
        }

        // Tampilkan view
        return view('reset-password', $data);
    }
    public function forgotPassword()
    {
        return view('forgot-password');
    }
    // =========================
    // PROCESS RESET PASSWORD
    // =========================
    public function resetPasswordProcess()
    {
        $email = $this->request->getPost('email');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            session()->setFlashdata('reset_email', $email);
            return redirect()->to('/reset-password')->with('error', 'Konfirmasi kata sandi tidak cocok!');
        }

        $userModel = new \App\Models\UserModel(); 
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            $userModel->update($user['id'], [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);

            return redirect()->to('/login')->withInput()->with('success', 'Kata sandi berhasil diubah! Silakan masuk dengan sandi baru Anda.');
        }

        return redirect()->to('/forgot-password')->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
    }
}