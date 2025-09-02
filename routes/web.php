<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

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

    // CRUD usuarios protegido por UserPolicy (authorizeResource en el controller)
    Route::resource('users', UserController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
