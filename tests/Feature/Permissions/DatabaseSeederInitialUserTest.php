<?php

use App\Models\User;

use function Pest\Laravel\artisan;

it('DatabaseSeeder crea usuario admin@local.test con rol admin en entorno testing', function () {
    // Act: corre el seeder principal
    artisan('db:seed', ['--no-interaction' => true])->assertSuccessful();

    // Assert usuario
    $user = User::whereEmail('admin@local.test')->first();
    expect($user)->not->toBeNull();
    
    // Assert rol asignado
    expect($user->hasRole('admin'))->toBeTrue();
});
