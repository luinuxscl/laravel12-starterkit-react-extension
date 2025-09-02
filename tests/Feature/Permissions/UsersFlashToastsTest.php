<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use function Pest\Laravel\patch;

beforeEach(function () {
    $this->seed(BaseSystemSeeder::class);
});

it('muestra flash.success al crear usuario con permisos', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    $response = post('/users', [
        'name' => 'Toast User',
        'email' => 'toast@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/users');
    $response->assertSessionHas('flash.success');
});

it('no muestra flash.success y devuelve 403 al crear sin permisos', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    $response = post('/users', [
        'name' => 'Toast User 2',
        'email' => 'toast2@example.com',
        'password' => 'password123',
    ]);

    $response->assertForbidden();
    expect(session()->has('flash.success'))->toBeFalse();
});

it('muestra flash.success al actualizar con permisos', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $target = User::factory()->create(['email' => 'target@example.com']);

    actingAs($admin);

    $response = patch("/users/{$target->id}", [
        'name' => 'Updated Name',
        'email' => 'target@example.com',
        'password' => '',
    ]);

    $response->assertRedirect("/users/{$target->id}");
    $response->assertSessionHas('flash.success');
});

it('muestra flash.success al eliminar con permisos', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $target = User::factory()->create();

    actingAs($admin);

    $response = delete("/users/{$target->id}");

    $response->assertRedirect('/users');
    $response->assertSessionHas('flash.success');
});
