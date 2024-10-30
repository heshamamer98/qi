<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'admin',
                'password' => Hash::make('password')
            ]
        );

        User::firstOrCreate(
            [
                'email' => 'manager@gmail.com',
            ],
            [
                'name' => 'manager',
                'password' => Hash::make('password')
            ]
        );
        User::firstOrCreate(
            [
                'email' => 'developer@gmail.com',
            ],
            [
                'name' => 'developer',
                'password' => Hash::make('password')
            ]
        );
    }
}
