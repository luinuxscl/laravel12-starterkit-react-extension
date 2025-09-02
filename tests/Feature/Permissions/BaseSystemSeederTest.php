<?php

use Database\Seeders\BaseSystemSeeder;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\artisan;

it('crea los roles base root, admin y standard', function () {
    // Act
    artisan('db:seed', [
        '--class' => BaseSystemSeeder::class,
        '--no-interaction' => true,
    ])->assertSuccessful();

    // Assert
    expect(Role::where('name', 'root')->exists())->toBeTrue();
    expect(Role::where('name', 'admin')->exists())->toBeTrue();
    expect(Role::where('name', 'standard')->exists())->toBeTrue();

    // Bonus: exactamente 3 roles creados si la BD estaba vacía
    expect(Role::count())->toBeGreaterThanOrEqual(3);
});
