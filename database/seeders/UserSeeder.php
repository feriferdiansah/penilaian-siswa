<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => env('ADMIN_NAME'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => env('GURU_EMAIL')],
            [
                'name' => env('GURU_NAME'),
                'password' => Hash::make(env('GURU_PASSWORD')),
                'role' => 'guru',
            ]
        );
    }
}