<?php

namespace Database\Seeders;

use App\Models\Team;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Sabre\CalDAV\Backend\BackendInterface;
use App\Http\Services\LaravelSabreCalendarHome;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        // $laravelCalendarHome=new LaravelSabreCalendarHome();
        
        $this->call(RoleSeeder::class);
       
        //create User Admin
        $admin=User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
        ]);
        $admin->createPrincipal();
        $admin->assignJustRole('Admin');


        //Moderateurs et 1 teams par moderateur
        $moderateurs=User::factory(3)->create();
        foreach ($moderateurs as $moderateur) {
           $moderateur->createPrincipal();
           $moderateur->createTeamPrincipal($moderateur->username); 
        }
        // dd('ok');


        $teams = Team::all();
        foreach ($teams as $team) {
            User::factory(3)->create()->each(function ($user) use ($team) {
                $user->createPrincipal();
                $user->joinTeam('Utilisateur',$team->id);

            });
        }
    }
}
