<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'manage.settings',
            'permissions.index',
            'permissions.indexAjax',
            'permissions.create',
            'permissions.store',
            'permissions.edit',
            'permissions.update',
            'permissions.destroy',
            'roles.index',
            'roles.create',
            'roles.store',
            'roles.edit',
            'roles.update',
            'roles.destroy',
            'roles.assignPermission',
            'users.index',
            'users.store',
            'users.create',
            'users.edit',
            'users.update',
            'users.destroy',
            'users.assignRole',
            'states.index',
            'states.create',
            'states.store',
            'states.edit',
            'states.update',
            'states.destroy',
            'cities.index',
            'cities.create',
            'cities.store',
            'cities.edit',
            'cities.update',
            'cities.destroy',
            'emails.index',
            'emails.create',
            'emails.store',
            'emails.edit',
            'emails.update',
            'emails.destroy',
            'templates.index',
            'templates.create',
            'templates.store',
            'templates.edit',
            'templates.update',
            'templates.destroy',
            'manage.management'
        ];

        foreach ($permissions as $row) :
            $permission = Permission::where('name', '=', $row)->first();

            if ($permission === NULL) : 
                Permission::create([
                    'name'          => $row,
                    'guard_name'    => 'web'
                ]);

                if ($row === 'manage.management'):
                    $role1 = Role::find(1);
                    $role1->givePermissionTo($row);
                    $role2  = Role::find(5);
                    $role2->givePermissionTo($row);
                else:
                    $role = Role::find(1);
                    $role->givePermissionTo($row);
                endif;                
            endif;
        endforeach;
    }
}
