<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin Perpus',
            'email' => 'admin@elibrary.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // // User Mahasiswa
        // \App\Models\User::factory()->create([
        //     'name' => 'Budi Santoso',
        //     'email' => 'budi@mhs.com',
        //     'role' => 'mahasiswa',
        //     'password' => bcrypt('password'),
        // ]);;
    }
}
