<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->seed(BaseSystemSeeder::class);
});

it('standard puede acceder a edit de su propio usuario, pero no tiene permiso users.update', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');

    actingAs($standard);

    get("/users/{$standard->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/edit')
            ->where('auth.permissions', fn ($perms) => ! collect($perms)->contains('users.update'))
            ->where('user.id', $standard->id)
        );
});

it('standard NO puede acceder a edit de otro usuario (403)', function () {
    $standard = User::factory()->create();
    $standard->assignRole('standard');
    $other = User::factory()->create();

    actingAs($standard);

    get("/users/{$other->id}/edit")->assertForbidden();
});

it('admin accede a edit con permiso users.update', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $target = User::factory()->create();

    actingAs($admin);

    get("/users/{$target->id}/edit")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/edit')
            ->where('auth.permissions', fn ($perms) => collect($perms)->contains('users.update'))
            ->where('user.id', $target->id)
        );
});

it('admin ve el listado de usuarios (componente users/index) y posee permiso users.create', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    actingAs($admin);

    get('/users')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('users/index')
            ->where('auth.permissions', function ($perms) {
                $c = collect($perms);
                return $c->contains('users.create') && $c->contains('users.update') && $c->contains('users.delete');
            })
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
            ->where('roles', fn ($roles) => collect($roles)->isNotEmpty())
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
