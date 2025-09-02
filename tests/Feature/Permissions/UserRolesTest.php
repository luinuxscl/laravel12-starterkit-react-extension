<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\assertDatabaseHas;

it('admin puede crear usuario con rol standard', function () {
    $this->seed(BaseSystemSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    $payload = [
        'name' => 'Nuevo Standard',
        'email' => 'nuevo.standard@example.com',
        'password' => 'password123',
        'roles' => ['standard'],
    ];

    $response = post('/users', $payload);
    $response->assertRedirect('/users');

    assertDatabaseHas('users', [
        'email' => 'nuevo.standard@example.com',
    ]);

    $created = User::where('email', 'nuevo.standard@example.com')->firstOrFail();
    expect($created->hasRole('standard'))->toBeTrue();
});

it('admin NO puede asignar rol root al crear', function () {
    $this->seed(BaseSystemSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    $payload = [
        'name' => 'Intento Root',
        'email' => 'intento.root@example.com',
        'password' => 'password123',
        'roles' => ['root'],
    ];

    $response = post('/users', $payload);
    $response->assertForbidden();
});

it('root puede crear usuario con rol root', function () {
    $this->seed(BaseSystemSeeder::class);

    $root = User::factory()->create();
    $root->assignRole('root');

    actingAs($root);

    $payload = [
        'name' => 'Root Asignado',
        'email' => 'root.asignado@example.com',
        'password' => 'password123',
        'roles' => ['root'],
    ];

    $response = post('/users', $payload);
    $response->assertRedirect('/users');

    $created = User::where('email', 'root.asignado@example.com')->firstOrFail();
    expect($created->hasRole('root'))->toBeTrue();
});

it('usuario standard no puede crear usuarios', function () {
    $this->seed(BaseSystemSeeder::class);

    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    $payload = [
        'name' => 'X',
        'email' => 'x@example.com',
        'password' => 'password123',
        'roles' => ['standard'],
    ];

    $response = post('/users', $payload);
    $response->assertForbidden();
});
