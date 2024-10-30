<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::firstOrCreate(['title' => 'open']);
        Status::firstOrCreate(['title' => 'in progress']);
        Status::firstOrCreate(['title' => 'frozen']);
        Status::firstOrCreate(['title' => 'review']);
        Status::firstOrCreate(['title' => 'done']);
    }
}
