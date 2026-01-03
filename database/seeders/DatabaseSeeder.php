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
        // Seed roles
        \App\Models\Role::insert([
            ['name' => 'superadmin'],
            ['name' => 'hr'],
            ['name' => 'supervisor'],
            ['name' => 'pelamar'],
        ]);

        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => \App\Models\Role::where('name','pelamar')->first()->id,
        ]);
    }
}
