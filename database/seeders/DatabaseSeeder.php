<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Semillas base del sistema (roles, permisos, etc.)
        $this->call([
            BaseSystemSeeder::class,
        ]);

        // Usuario inicial solo en entornos local / testing
        if (app()->environment(['local', 'testing'])) {
            $user = User::firstOrCreate(
                ['email' => 'admin@local.test'],
                [
                    'name' => 'Local Admin',
                    'password' => Hash::make('password'),
                ]
            );

            // Asignar rol "admin" (creado por BaseSystemSeeder)
            $user->syncRoles(['admin']);
        }
    }
}
