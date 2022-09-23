<?php

namespace Database\Seeders;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'email' => 'admin@bluebird.test',
            'password' => bcrypt('bluebird'),
        ]);

        $users = User::factory()->count(100)->create();
        foreach ($users as $user) {
            $chirps = Chirp::factory()->count(random_int(5, 10))->create();

            foreach ($chirps as $chirp) {
                Chirp::factory()
                    ->fromUser($user)
                    ->withParent($chirp)
                    ->count(random_int(2, 4))
                    ->create();
            }
        }
    }
}
