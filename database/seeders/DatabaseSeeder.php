<?php

namespace Database\Seeders;

use App\Models\Team;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Sabre\CalDAV\Backend\BackendInterface;
use App\Http\Services\LaravelSabreCalendarHome;
use Illuminate\Support\Facades\DB;
use Sabre\CalDAV\Backend\PDO;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $backendInterface = new PDO(DB::getPdo());
        $laravelCalendarHome=new LaravelSabreCalendarHome($backendInterface);
        
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
            
            $user->assignRoleAndTeam('Moderateur', $team->id);
            $user->createPrincipal();
            $laravelCalendarHome->createCalendarTeamOrUser('CalendarUser', str_replace(' ', '', $user->name), $user);
        });

        $teams = Team::all();
        foreach ($teams as $team) {
            User::factory(5)->create()->each(function ($user) use ($team, $laravelCalendarHome) {
                
                $user->assignRoleAndTeam('Utilisateur',$team->id);
                $user->createPrincipal();
                $laravelCalendarHome->createCalendarTeamOrUser('CalendarUser', 'lecalendrierde' . str_replace(' ', '', $user->name), $user);

            });
        }
    }
}
