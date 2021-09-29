<?php

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SuperAdmin',
            'Admin',
            'Supervisor',
            'Abogado',
            'Gestor'
        ];

        foreach ($roles as $row) :
            $role = Role::where('name', '=', $row)->first();

            if ($role === NULL) : 
                Role::create([
                    'name'      => $row,
                    'guard_name'=> 'web'
                ]);
            endif;
        endforeach;
    }
}
