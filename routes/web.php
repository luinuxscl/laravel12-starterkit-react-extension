<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Ruta de ejemplo protegida por roles (admin o root)
    Route::get('admin-only', function () {
        return response('Admin area', 200);
    })->middleware(['role:admin|root'])->name('admin.only');

    // Rutas de ejemplo protegidas por UserPolicy
    Route::get('users', function () {
        // Ejemplo: listado (no implementado). Solo valida autorización.
        return response('Users index (authorized)', 200);
    })->middleware('can:viewAny,'.User::class)->name('users.index');

    Route::get('users/{user}', function (User $user) {
        return response("User view (authorized): {$user->id}", 200);
    })->middleware('can:view,user')->name('users.show');

    Route::patch('users/{user}', function (Request $request, User $user) {
        // No persistimos cambios; es solo para validar autorización de update
        return response('User update allowed (no-op)', 200);
    })->middleware('can:update,user')->name('users.update');

    Route::delete('users/{user}', function (User $user) {
        // No eliminamos realmente; solo validamos autorización de delete
        return response('User delete allowed (no-op)', 200);
    })->middleware('can:delete,user')->name('users.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
