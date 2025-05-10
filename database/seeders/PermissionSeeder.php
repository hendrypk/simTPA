<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $entities = [
        //     'student',
        //     'donor',
        //     'employee',
        //     'donate',
        //     'transaction',
        //     'financial_planning',
        //     'setting',
        //     'permission',
        //     'role',
        //     'dashboard',
        //     'vendor'
        // ];

        // $actions = ['view', 'create', 'update', 'delete'];

        // foreach ($entities as $entity) {
        //     foreach ($actions as $action) {
        //         $permissionName = "$action $entity";
        //         Permission::updateOrCreate(
        //             [
        //                 'name' => $permissionName,
        //                 'guard_name' => 'web',
        //             ],
        //             [
        //                 'group_name' => $entity,
        //             ]
        //         );
        //     }
        // }
        
    }
}
