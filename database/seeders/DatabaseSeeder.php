<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        //create User Admin
        // $admin = User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@test.com',
        //     'username' => 'admin',

        // ]);

        // $admin->createPrincipal();

        // $admin->assignJustRole('Admin');

        $admin = User::factory()->create([
            'name' => 'Christophe Leininger',
            'email' => 'cleininger@b2pweb.com',
            'username' => 'cleininger',

        ]);

        $admin->createPrincipal();

        $admin->assignJustRole('Admin');

        //moderators et 1 teams par moderator
        $moderators = User::factory(3)->create();
        foreach ($moderators as $moderator) {
            $moderator->createPrincipal();

            $moderator->createTeamPrincipal('team '.$moderator->username);
        }

        $teams = Team::all();
        foreach ($teams as $team) {
            User::factory(3)->create()->each(function ($user) use ($team) {
                $user->createPrincipal();
                $user->joinTeam('User', $team->id);
            });
        }

        $this->call(EventSeeder::class);
    }
}
