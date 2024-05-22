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
       
        $laravelCalendarHome=new LaravelSabreCalendarHome();
        

        //faire les seeders
        // User::
        $this->call(RoleSeeder::class);
       
        //create User Admin
        $admin=User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
        ])->assignRole('Admin');

        $admin->createPrincipal();
        $laravelCalendarHome->createCalendarTeamOrUser('CalendarUser','lecalendrierdeAdmin', $admin);
       
        
        
        
        
        
        //create User Moderateur *3 et 1 teams par moderateur
        User::factory(3)->withPersonalTeam()->create()->each(function ($user) use ($laravelCalendarHome){
            $team = $user->ownedTeams()->first();
            $team->createPrincipal();
            $laravelCalendarHome->createCalendarTeamOrUser('CalendarTeam', str_replace(' ', '', $team->name), $team);
            
            // $team->users()->attach($user->id);
            $user->assignRoleAndTeam('Moderateur', $team->id);
            $user->createPrincipal();
            $laravelCalendarHome->createCalendarTeamOrUser('CalendarUser', str_replace(' ', '', $user->name), $user);
            // $user->assignRole('Moderateur');
            // $team = $user->ownedTeams()->first();
            // $modelRole=$user->assignModelRole()->first();
            // $team->users()->attach($user->id, ['role' => 1, 'model_type' => 'App\Models\User']);
            // $modelRole->team_id=$team->id;

        });
        // dd('ok');
        
        
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
            User::factory(5)->create()->each(function ($user) use ($team, $laravelCalendarHome) {
                
                $user->assignRoleAndTeam('Utilisateur',$team->id);
                $user->createPrincipal();
                $laravelCalendarHome->createCalendarTeamOrUser('CalendarUser', 'lecalendrierde' . str_replace(' ', '', $user->name), $user);

            });
        }
        // dd('ok');
    }
}
