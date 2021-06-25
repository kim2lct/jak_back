<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
            foreach(['superuser','user'] as $role){
                Role::create([
                    'name'=>$role
                ]);
            }
        
            $user = User::create([
                'name'=>'super admin',
                'email'=>'admin@mail.com',
                'password'=>Hash::make('adminku'),
            ]);

            $user->roles()->create([
            'role_id'=>1,            
            ]);
        

    }
}
