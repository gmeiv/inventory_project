<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create default admin if not exists
        if (!Admin::where('email', 'admin')->exists()) {
            Admin::create([
                'surname' => 'admin',
                'middlename' => 'admin',
                'firstname' => 'admin',
                'department' => 'admin',
                'position' => 'admin',
                'employment_type' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
            ]);
        }
    }
}
