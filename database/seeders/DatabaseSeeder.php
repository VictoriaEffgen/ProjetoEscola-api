<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Victoria',
            'age' => 24,
            'email' => 'effgenvictoria@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'coordinator'
        ]);

        Coordinator::create([
            'user_id' => 1
        ]);
    }
}
