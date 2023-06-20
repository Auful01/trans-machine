<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'identity_num' => '1941720001',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1
            ],
            [
                'name' => 'Dosen',
                'identity_num' => '1941720002',
                'email' => 'dosen@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2
            ],
            [
                'name' => 'Mahasiswa',
                'identity_num' => '1941720003',
                'email' => 'mahasiswa@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 3
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
