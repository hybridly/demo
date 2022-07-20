<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@bluebird.test',
            'password' => Hash::make('bluebird'),
        ]);

        User::factory()
            ->count(100)
            ->has(Chirp::factory()->count(rand(10, 50)))
            ->create();
    }
}
