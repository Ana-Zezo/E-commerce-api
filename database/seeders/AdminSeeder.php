<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
             'name' => 'Elsayed&Nasser',
             'email' => 'admin123@example.com',
             'password' => \Hash::make('12345678'),
             
         ]);
    }
}
