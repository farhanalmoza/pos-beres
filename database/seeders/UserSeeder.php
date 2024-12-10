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
     */
    public function run(): void
    {
        // check if user with role admin is empty
        if (User::where('role', 'admin')->count() == 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin1@example.com',
                'password' => Hash::make('12345'),
                'role' => 'admin',
            ]);
        }
    }
}
