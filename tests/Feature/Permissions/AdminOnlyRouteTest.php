<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\artisan;

it('permite acceso a /admin-only para usuario con rol admin', function () {
    // Seed base roles
    artisan('db:seed', ['--class' => BaseSystemSeeder::class, '--no-interaction' => true])->assertSuccessful();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    // Asignar rol admin
    $user->syncRoles(['admin']);

    actingAs($user);

    get(route('admin.only'))
        ->assertOk()
        ->assertSee('Admin area');
});

it('deniega acceso a /admin-only para usuario sin rol requerido', function () {
    // Seed base roles (no se asignará ninguno al usuario)
    artisan('db:seed', ['--class' => BaseSystemSeeder::class, '--no-interaction' => true])->assertSuccessful();

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    // Usuario sin roles

    actingAs($user);

    get(route('admin.only'))
        ->assertForbidden();
});
