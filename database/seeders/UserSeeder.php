<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Tag;
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

        // Give the demo user 3 events
        Event::factory()->count(3)->create([
            'creator_id' => $defaultUser->id,
        ]);

        // Attach random tags to the demo user
        $defaultUser->tags()->attach(Tag::inRandomOrder()->take(3)->pluck('id'));

        // Create 5 additional users
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                // Each user gets 2–4 events
                Event::factory()->count(rand(2, 4))->create([
                    'creator_id' => $user->id,
                ]);

                // Each user gets 1–3 tags
                $user->tags()->attach(
                    Tag::inRandomOrder()->take(rand(1, 3))->pluck('id')
                );
            });
    }
}
