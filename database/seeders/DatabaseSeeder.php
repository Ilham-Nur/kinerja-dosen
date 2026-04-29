<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin001'],
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@kampus.local',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['username' => 'dosen001'],
            [
                'name' => 'Dosen Demo',
                'email' => 'dosen@kampus.local',
                'password' => 'password',
                'role' => 'dosen',
            ]
        );

        // User::factory(10)->create();
    }
}
