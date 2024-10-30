<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'edit user']);
        Permission::firstOrCreate(['name' => 'delete user']);
        Permission::firstOrCreate(['name' => 'create user']);
        Permission::firstOrCreate(['name' => 'view user']);

        Permission::firstOrCreate(['name' => 'edit project']);
        Permission::firstOrCreate(['name' => 'delete project']);
        Permission::firstOrCreate(['name' => 'create project']);
        Permission::firstOrCreate(['name' => 'view project']);

        Permission::firstOrCreate(['name' => 'edit task']);
        Permission::firstOrCreate(['name' => 'delete task']);
        Permission::firstOrCreate(['name' => 'create task']);
        Permission::firstOrCreate(['name' => 'view task']);

        Permission::firstOrCreate(['name' => 'edit comment']);
        Permission::firstOrCreate(['name' => 'delete comment']);
        Permission::firstOrCreate(['name' => 'create comment']);
        Permission::firstOrCreate(['name' => 'view comment']);


        $adminRole = Role::firstOrCreate(['name' => RoleName::ADMIN]);
        if ($adminRole->wasRecentlyCreated) {
            $adminRole->givePermissionTo(Permission::all());
        }

        $managerRole = Role::firstOrCreate(['name' => RoleName::MANAGER]);
        if ($managerRole->wasRecentlyCreated) {
            $managerRole->givePermissionTo([
                'edit project',
                'delete project',
                'create project',
                'view project',

                'edit task',
                'delete task',
                'create task',
                'view task',

                'edit comment',
                'delete comment',
                'create comment',
                'view comment'
            ]);
        }

        $developerRole = Role::firstOrCreate(['name' => RoleName::DEVELOPER]);
        if ($developerRole->wasRecentlyCreated) {
            $developerRole->givePermissionTo([
                'edit comment',
                'delete comment',
                'create comment',
                'view comment'
            ]);
        }

        $admin = User::where('name', 'admin')->first();
        if (!$admin->hasRole([RoleName::ADMIN])) {
            $admin->assignRole($adminRole);
        }

        $manager = User::where('name', 'manager')->first();
        if (!$manager->hasRole([RoleName::MANAGER])) {
            $manager->assignRole($managerRole);
        }

        $developer = User::where('name', 'developer')->first();
        if (!$developer->hasRole([RoleName::DEVELOPER])) {
            $developer->assignRole($developerRole);
        }
    }
}
