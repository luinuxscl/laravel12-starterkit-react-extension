<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AppInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--dev : Seed de datos de ejemplo (usuarios demo y roles asignados)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instalación base del sistema: migraciones, seeds y (opcional) datos de desarrollo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando instalación base...');

        // 1) Migraciones
        $this->call('migrate', ['--graceful' => true]);

        // 2) Seed base del sistema (roles)
        $this->call('db:seed', [
            '--class' => 'Database\\Seeders\\BaseSystemSeeder',
            '--no-interaction' => true,
        ]);

        // 3) Si --dev, crear usuarios demo y asignar roles
        if ($this->option('dev')) {
            $this->line('Creando usuarios demo (--dev)...');

            $demoUsers = [
                ['email' => 'root@demo.com', 'name' => 'Root User', 'role' => 'root'],
                ['email' => 'admin@demo.com', 'name' => 'Admin User', 'role' => 'admin'],
                ['email' => 'standard@demo.com', 'name' => 'Standard User', 'role' => 'standard'],
            ];

            foreach ($demoUsers as $data) {
                $user = User::firstOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['name'],
                        'password' => Hash::make('password'), // Solo dev
                    ]
                );

                // Asegurar que el rol exista (por si el seeder fue alterado)
                $role = Role::firstOrCreate(['name' => $data['role'], 'guard_name' => 'web']);
                $user->syncRoles([$role->name]);
            }

            $this->info('Usuarios demo creados con contraseña por defecto: "password"');
        }

        $this->info('Instalación completada.');
        return self::SUCCESS;
    }
}
