<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Roles y permisos base
    $this->seed(\Database\Seeders\BaseSystemSeeder::class);

    // Usuario autenticado con permisos de lectura
    $user = User::factory()->create();
    // Asignar rol admin para pasar policies de users.*
    $user->assignRole('admin');
    $this->actingAs($user);
});

it('devuelve estructura paginada con UserResource en index', function () {
    User::factory()->count(3)->create();

    $response = $this->get(route('users.index'));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('users/index')
        ->has('users.data')
        ->has('users.data.0', fn (Assert $user) => $user
            ->has('id')
            ->has('name')
            ->has('email')
        )
        ->has('users.links')
        ->has('filters', fn (Assert $filters) => $filters
            ->where('q', '')
            ->where('sort', 'id')
            ->where('dir', 'desc')
        )
    );
});

it('devuelve un usuario con UserResource en show', function () {
    $user = User::factory()->create();

    $response = $this->get(route('users.show', $user));

    $response->assertInertia(fn (Assert $page) => $page
        ->component('users/show')
        ->has('user', fn (Assert $u) => $u
            ->where('id', $user->id)
            ->where('name', $user->name)
            ->where('email', $user->email)
        )
    );
});
