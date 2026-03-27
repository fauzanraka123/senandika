<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Senandika',
            'email' => 'admin@senandika.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Administrator of the Senandika platform.',
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'writer@senandika.test',
            'password' => Hash::make('password'),
            'role' => 'writer',
            'bio' => 'A passionate poet exploring the depths of human emotions.',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'reader@senandika.test',
            'password' => Hash::make('password'),
            'role' => 'reader',
        ]);
    }
}
