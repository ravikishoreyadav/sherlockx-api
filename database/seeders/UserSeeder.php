<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_list = Permission::create(['name'=>'user-list']);
        $user_create = Permission::create(['name'=>'user-create']);
        $user_edit = Permission::create(['name'=>'user-edit']);
        $user_delete = Permission::create(['name'=>'user-delete']);

        $admin_role = Role::create(['name'=>'Admin']);
        $admin_role->givePermissionTo([
            $user_list,
            $user_create,
            $user_edit,
            $user_delete
        ]);
        $admin = User::create([
            'name' => 'Admin',
            'email'=> 'admin@mailinator.com',
            'password'=> bcrypt('LightYellow#84')
        ]);
        $admin->assignRole($admin_role);

        $user_role = Role::create(['name'=>'User']);
        $user_role->givePermissionTo([
            $user_list,
        ]);
        $user = User::create([
            'name' => 'User',
            'email'=> 'user@mailinator.com',
            'password'=> bcrypt('LightYellow#84')
        ]);
        $user->assignRole($user_role);
    }
}
