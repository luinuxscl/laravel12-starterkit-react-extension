<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete; // for route delete
use function Pest\Laravel\get;    // for index/show
use function Pest\Laravel\patch;  // for update
use function Pest\Laravel\post;   // for create

beforeEach(function () {
    $this->seed(BaseSystemSeeder::class);
});

it('standard NO puede ver el listado de usuarios (403) sin permiso users.viewAny', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    $response = get('/users');
    $response->assertForbidden();
});

it('standard puede verse a sí mismo y no a otros sin permiso', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    $other = User::factory()->create();

    actingAs($standard);

    // Propio
    get("/users/{$standard->id}")->assertOk();

    // Ajeno
    get("/users/{$other->id}")->assertForbidden();
});

it('standard no puede crear usuarios', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');
    actingAs($standard);

    post('/users', [
        'name' => 'X',
        'email' => 'x@example.com',
        'password' => 'password123',
    ])->assertForbidden();
});

it('admin puede crear y actualizar usuarios por permisos', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    actingAs($admin);

    // Crear
    $resp = post('/users', [
        'name' => 'Nuevo',
        'email' => 'nuevo@example.com',
        'password' => 'password123',
    ]);
    $resp->assertRedirect('/users');

    $created = User::where('email', 'nuevo@example.com')->firstOrFail();

    // Actualizar
    patch("/users/{$created->id}", [
        'name' => 'Actualizado',
        'email' => 'nuevo@example.com',
        'password' => '',
    ])->assertRedirect("/users/{$created->id}");
});

it('no permite auto-eliminar y exige permiso para eliminar a otros', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    actingAs($admin);

    // Auto delete bloqueado
    delete("/users/{$admin->id}")->assertForbidden();

    $other = User::factory()->create();

    // Admin tiene users.delete por seed
    delete("/users/{$other->id}")->assertRedirect('/users');
});
