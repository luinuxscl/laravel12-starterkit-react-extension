<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->seed(BaseSystemSeeder::class);
});

it('admin ve el listado de usuarios (componente users/index) y posee permiso users.create', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    get('/users')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/index')
            ->where('auth.permissions', fn ($perms) => collect($perms)->contains('users.create'))
        );
});

it('standard NO puede ver el listado (403)', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    get('/users')->assertForbidden();
});

it('admin puede acceder a create (componente users/create) y tiene permiso users.create', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    get('/users/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/create')
            ->where('auth.permissions', fn ($perms) => collect($perms)->contains('users.create'))
        );
});

it('standard no puede acceder a create (403)', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    get('/users/create')->assertForbidden();
});

it('standard puede ver su propio show (componente users/show) y no tiene permiso users.update', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    get("/users/{$standard->id}")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/show')
            ->where('auth.permissions', fn ($perms) => ! collect($perms)->contains('users.update'))
        );
});
