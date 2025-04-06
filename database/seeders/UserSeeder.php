<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create one demo user manually
        $defaultUser = User::create([
            'name' => 'Demo User',
            'email' => 'demo@studentious.com',
            'password' => Hash::make('password'),
        ]);

        // Give the demo user some events
        Event::factory()->count(3)->create([
            'creator_id' => $defaultUser->id,
        ]);

        // Create 5 more users and assign each random events
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                Event::factory()->count(rand(2, 4))->create([
                    'creator_id' => $user->id,
                ]);
            });
    }
}
