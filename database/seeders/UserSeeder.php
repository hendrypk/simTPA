<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $user = User::updateOrCreate(
        //     ['email' => 'hendryputra934@gmail.com'],
        //     [
        //         'name' => 'superadmin',
        //         'username' => 'superadmin',
        //         'phone' => '085842233005',
        //         'password' => Hash::make('superadmin'),
        //     ]
        // );

        // $adminRole = Role::where('name', 'admin')->first();
        // if ($adminRole) {
        //     $user->assignRole($adminRole);
        // }
    }
}
