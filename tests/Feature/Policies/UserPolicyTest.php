<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;

beforeEach(function () {
    // Asegura roles base
    (new BaseSystemSeeder())->run();
});

it('permite a root hacer viewAny/view/create/update/delete sobre usuarios', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $target = User::factory()->create();

    expect($root->can('viewAny', User::class))->toBeTrue();
    expect($root->can('view', $target))->toBeTrue();
    expect($root->can('create', User::class))->toBeTrue();
    expect($root->can('update', $target))->toBeTrue();
    expect($root->can('delete', $target))->toBeTrue();
});

it('permite a admin ver y gestionar usuarios (excepto restricciones de policy)', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $target = User::factory()->create();

    expect($admin->can('viewAny', User::class))->toBeTrue();
    expect($admin->can('view', $target))->toBeTrue();
    expect($admin->can('create', User::class))->toBeTrue();
    expect($admin->can('update', $target))->toBeTrue();
    expect($admin->can('delete', $target))->toBeTrue();
});

it('permite a standard verse y actualizarse a sí mismo, pero no listar ni crear', function () {
    $user = User::factory()->create();
    $user->assignRole('standard');

    $other = User::factory()->create();

    expect($user->can('viewAny', User::class))->toBeFalse();
    expect($user->can('create', User::class))->toBeFalse();

    expect($user->can('view', $user))->toBeTrue();
    expect($user->can('update', $user))->toBeTrue();

    expect($user->can('view', $other))->toBeFalse();
    expect($user->can('update', $other))->toBeFalse();
    expect($user->can('delete', $other))->toBeFalse();
});

it('impide que un usuario se elimine a sí mismo', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    expect($admin->can('delete', $admin))->toBeFalse();
});
