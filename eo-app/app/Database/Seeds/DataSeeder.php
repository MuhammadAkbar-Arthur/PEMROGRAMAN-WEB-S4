<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Organizers (Pastikan nama kolom 'bio' sesuai dengan di DB kamu)
        $organizers = [
            ['id' => 17, 'name' => 'EO2 Official', 'email' => 'organizer2@eo.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'organizer', 'bio' => 'Penyelenggara event kampus.', 'phone' => '081222333444'],
            ['id' => 18, 'name' => 'EO3 Official', 'email' => 'organizer3@eo.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'organizer', 'bio' => 'Spesialis turnamen gaming.', 'phone' => '081222333555'],
            ['id' => 19, 'name' => 'EO4 Official', 'email' => 'organizer4@eo.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'organizer', 'bio' => 'Penyelenggara seminar IT.', 'phone' => '081222333666']
        ];
        $this->db->table('users')->insertBatch($organizers);

        // 2. Seed Events
        $events = [];
        $ownerIds = [17, 18, 19];
        
        foreach ($ownerIds as $oid) {
            for ($i = 1; $i <= 3; $i++) {
                $events[] = [
                    'title'       => "Event Seri $i - EO ID $oid",
                    'description' => "Deskripsi profesional untuk event seri ke-$i.",
                    'location'    => "Mataram City",
                    'date'        => date('Y-m-d', strtotime("+$i days")),
                    'quota'       => 100,
                    'category_id' => 1, 
                    'owner_id'    => $oid
                ];
            }
        }
        $this->db->table('events')->insertBatch($events);
    }
}