<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = User::create([
            'full_name' => 'Admin Satu',
            'phone_number' => '082133898765',
            'email' => 'admin1@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
        $admin1->assignRole('admin');
        $admin2 = User::create([
            'full_name' => 'Admin Dua',
            'phone_number' => '082133898765',
            'email' => 'admin2@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
        $admin2->assignRole('admin');
        $user1 = User::create([
            'full_name' => 'User Satu',
            'phone_number' => '082133768997',
            'email' => 'user1@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
        $user2 = User::create([
            'full_name' => 'User Dua',
            'phone_number' => '082133768997',
            'email' => 'user2@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
    }
}
