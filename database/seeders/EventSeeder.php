<?php

namespace Database\Seeders;

use App\Models\Events;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $numberOfEvents = rand(8, 16); // Nombre aléatoire d'événements par utilisateur

            Events::factory($numberOfEvents)->create([
                'user_id' => $user->id,
                'backgroundColor' => $user->color, 'borderColor' => $user->color.'80',

            ]);
        }
    }
}
