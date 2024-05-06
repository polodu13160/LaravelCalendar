<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=["Admin", "Moderateur", "Utilisateur"]; 

        foreach($roles as $role){
            Role::create(['name'=>$role]);
            
        }
        Permission::create(['name'=>'group.*'])
        ->assignRole(Role::firstWhere('name','Moderateur'));
       
    }
}
