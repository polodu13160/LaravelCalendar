<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        //faire les seeders
        // User::
        $this->call(RoleSeeder::class);
       
        //create User Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
        ])->assignRole('Admin');
        
        
        
        
        //create User Moderateur *3 et 1 teams par moderateur
        User::factory(3)->withPersonalTeam()->create()->each(function ($user) {
            $team = $user->ownedTeams()->first();
            // $team->users()->attach($user->id);
            $user->assignRoleAndTeam('Moderateur', $team->id);
            // $user->assignRole('Moderateur');
            // $team = $user->ownedTeams()->first();
            // $modelRole=$user->assignModelRole()->first();
            // $team->users()->attach($user->id, ['role' => 1, 'model_type' => 'App\Models\User']);
            // $modelRole->team_id=$team->id;

        });
        
        
        // foreach ($users as $user) {
        //     $team = $user->ownedTeams()->first();
        //     if ($team) {
        //         $team->users()->attach($user->id);
        //         $user->current_team_id=$team->id;
        //         $user->save();
        //     }
        // }
        
        //create User Utilisateur *5 par teams

        $teams = Team::all();
        foreach ($teams as $team) {
            User::factory(5)->create()->each(function ($user) use ($team) {
                
                $user->assignRoleAndTeam('Utilisateur',$team->id);
                
                

            });
        }
    }
}
