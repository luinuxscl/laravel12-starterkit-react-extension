<?php

use App\Models\User;

use function Pest\Laravel\artisan;

it('app:install --dev crea usuarios demo con roles asignados', function () {
    // Act
    artisan('app:install', ['--dev' => true])->assertSuccessful();

    // Assert usuarios
    $root = User::whereEmail('root@demo.com')->first();
    $admin = User::whereEmail('admin@demo.com')->first();
    $standard = User::whereEmail('standard@demo.com')->first();

    expect($root)->not->toBeNull();
    expect($admin)->not->toBeNull();
    expect($standard)->not->toBeNull();

    // Assert roles
    expect($root->hasRole('root'))->toBeTrue();
    expect($admin->hasRole('admin'))->toBeTrue();
    expect($standard->hasRole('standard'))->toBeTrue();
});
