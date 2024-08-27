<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin', 'Moderator', 'User'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        Permission::create(['name' => 'group.*'])
            ->assignRole(Role::firstWhere('name', 'Moderator'));
    }
}
