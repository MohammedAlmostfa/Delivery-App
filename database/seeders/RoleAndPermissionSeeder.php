<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $managerRole = Role::create(['name' => 'manager', 'guard_name' => 'api']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);

        // Create permissions
        $createRestaurant = Permission::create(['name' => 'restaurant.create', 'guard_name' => 'api']);
        $updateRestaurant = Permission::create(['name' => 'restaurant.update', 'guard_name' => 'api']);
        $forceDeleteRestaurant = Permission::create(['name' => 'restaurant.forceDelete', 'guard_name' => 'api']);
        $permanentlyDeleteRestaurant = Permission::create(['name' => 'restaurant.permanentDelete', 'guard_name' => 'api']);
        $restoreRestaurant = Permission::create(['name' => 'restaurant.restore', 'guard_name' => 'api']); // Fixed "restor" to "restore"

        // Assign permissions to admin role
        $adminRole->givePermissionTo([
            $createRestaurant,
            $updateRestaurant,
            $forceDeleteRestaurant,
            $permanentlyDeleteRestaurant,
            $restoreRestaurant,
        ]);

        // Assign permissions to manager role
        $managerRole->givePermissionTo([
            $updateRestaurant,
        ]);
    }
}
