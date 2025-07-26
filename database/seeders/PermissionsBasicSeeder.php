<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsBasicSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage all', 'guard_name' => 'api']);
        Permission::create(['name' => 'create Quotes', 'guard_name' => 'api']);
        Permission::create(['name' => 'read Quotes', 'guard_name' => 'api']);
        Permission::create(['name' => 'update Quotes', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete Quotes', 'guard_name' => 'api']);
        Permission::create(['name' => 'read Auth', 'guard_name' => 'api']);

        // create roles and assign existing permissions
        $roleAgent = Role::create(['name' => 'agent', 'guard_name' => 'api']);
        $roleAgent->givePermissionTo('create Quotes');
        $roleAgent->givePermissionTo('read Quotes');
        $roleAgent->givePermissionTo('update Quotes');
        $roleAgent->givePermissionTo('delete Quotes');
        $roleAgent->givePermissionTo('read Auth');

        $roleAdmin = Role::create(['name' => 'administrator', 'guard_name' => 'api']);
        $roleAdmin->givePermissionTo('manage all');
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $agents = User::where('level', 'user')->get();

        foreach ($agents as $agent) {
            $agent->assignRole($roleAgent);
        }

        $admins = User::where('level', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->assignRole($roleAdmin);
        }
    }
}
