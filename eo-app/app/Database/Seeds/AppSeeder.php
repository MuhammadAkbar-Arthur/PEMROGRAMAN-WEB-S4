<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. SEEDER: USERS (Admin, Organizer, User)
        // ==========================================
        $users = [
            [
                'name'     => 'System Administrator',
                'email'    => 'admin@eo.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'phone'    => '081200000000',
                'bio'      => 'Administrator utama sistem EO Management.',
                'avatar'   => null
            ],
            [
                'name'     => 'Arthur EO Official',
                'email'    => 'organizer@eo.com',
                'password' => password_hash('organizer123', PASSWORD_DEFAULT),
                'role'     => 'organizer',
                'phone'    => '081987654321',
                'bio'      => 'Penyelenggara event kampus dan turnamen gaming.',
                'avatar'   => null
            ],
            [
                'name'     => 'Muhammad Akbar',
                'email'    => 'akbar@user.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role'     => 'user',
                'phone'    => '081234567890',
                'bio'      => 'Mahasiswa Teknik Informatika penggiat IT.',
                'avatar'   => null
            ]
        ];

        // Insert tabel users
        $this->db->table('users')->insertBatch($users);

        // ==========================================
        // 2. SEEDER: CATEGORIES
        // ==========================================
        $categories = [
            ['name' => 'Seminar & Edukasi'],
            ['name' => 'Bootcamp & Workshop'],
            ['name' => 'Turnamen E-Sports'],
            ['name' => 'Konser Hiburan'],
            ['name' => 'Pameran Expo']
        ];

        // Insert tabel categories
        $this->db->table('categories')->insertBatch($categories);

        // ==========================================
        // 3. SEEDER: EVENTS DUMMY
        // ==========================================
        // Asumsi: ID 2 adalah akun Organizer "Arthur", ID 2 dan 3 adalah Kategori Bootcamp/E-Sports
        $events = [
            [
                'title'       => 'Bootcamp Web Development HMIF',
                'description' => 'Pelatihan intensif pengembangan aplikasi web menggunakan CodeIgniter 4 dan Tailwind CSS. Cocok untuk mahasiswa yang ingin memperdalam full-stack development.',
                'date'        => '2026-06-15',
                'location'    => 'Gedung Universitas Mataram',
                'category_id' => 2, // Bootcamp
                'quota'       => 50,
                'image'       => null, 
                'owner_id'    => 2 // ID Organizer Arthur EO
            ],
            [
                'title'       => 'Turnamen eFootball 2025 Campus Edition',
                'description' => 'Ajang unjuk taktik dan skill bermain eFootball tingkat universitas. Buktikan siapa manajer terbaik dengan formasi 4-3-1-2 andalanmu!',
                'date'        => '2026-06-25',
                'location'    => 'Arena E-Sports Mataram',
                'category_id' => 3, // Turnamen
                'quota'       => 64,
                'image'       => null, 
                'owner_id'    => 2 // ID Organizer Arthur EO
            ]
        ];

        // Insert tabel events
        $this->db->table('events')->insertBatch($events);
    }
}