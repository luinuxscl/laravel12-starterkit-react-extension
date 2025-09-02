<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BaseSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles base del sistema
        $roles = [
            'root',
            'admin',
            'standard',
        ];

        foreach ($roles as $name) {
            Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Permisos base del sistema
        $permissions = [
            'users.viewAny',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // Asignación de permisos por rol
        $root = Role::where('name', 'root')->first();
        $admin = Role::where('name', 'admin')->first();
        $standard = Role::where('name', 'standard')->first();

        // Root todo acceso
        $root?->givePermissionTo($permissions);

        // Admin acceso CRUD usuarios estándar
        $adminPermissions = [
            'users.viewAny',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];
        $admin?->givePermissionTo($adminPermissions);

        // Standard: solo lectura
        $standardPermissions = [
            'users.viewAny',
            'users.view',
        ];
        $standard?->givePermissionTo($standardPermissions);
    }
}
