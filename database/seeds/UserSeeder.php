<?php

use App\Models\Settings\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', '=', 'eduardoest@netstudios.com.mx')->first();

        if ($user === NULL):
            $password = 'mexico100';
            
            $user1 = User::create([
                'fullname'          => 'Administrador Netstudios',
                'email'             => 'eduardoest@netstudios.com.mx',
                'remember_token'    => Hash::make('eduardoest@netstudios.com.mx'),
                'password'          => Hash::make($password),
                'pass'              => $password,
                'status'            => 'Active',
                'verified'          => 'Verified',
                'updated_at'        => NULL
            ]);

            $role = Role::find(1);

            $user1->assignRole($role);
        endif;
    }
}
