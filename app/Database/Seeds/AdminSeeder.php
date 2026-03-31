<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'user_id'    => 1,
            'username'   => 'admin',
            'email'      => 'admin@gmail.com',
            // password: admin123 (bcrypt)
            'password'   => '$2y$10$BzOctZLZGFMUeyGscyM8IOD6cbtRJpnMpaVZYDgl90ueKB8QFIEJu',
            'role'       => 'admin',
            'status'     => 'active',
            'created_at' => '2024-12-10 21:49:44',
            'updated_at' => '2024-12-10 21:49:44',
        ];

        $this->db->table('users')->insert($data);
    }
}
