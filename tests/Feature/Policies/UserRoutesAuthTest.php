<?php

use App\Models\User;
use Database\Seeders\BaseSystemSeeder;

beforeEach(function () {
    (new BaseSystemSeeder())->run();
});

it('GET /users: root y admin 200, standard 403', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $standard = User::factory()->create();
    $standard->assignRole('standard');

    $this->actingAs($root)->get('/users')->assertOk();
    $this->actingAs($admin)->get('/users')->assertOk();
    $this->actingAs($standard)->get('/users')->assertForbidden();
});

it('GET /users/{user}: root/admin pueden ver cualquiera; standard solo a sí mismo', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $u1 = User::factory()->create();
    $u1->assignRole('standard');

    $u2 = User::factory()->create();
    $u2->assignRole('standard');

    $this->actingAs($root)->get("/users/{$u1->id}")->assertOk();
    $this->actingAs($admin)->get("/users/{$u2->id}")->assertOk();

    $this->actingAs($u1)->get("/users/{$u1->id}")->assertOk();
    $this->actingAs($u1)->get("/users/{$u2->id}")->assertForbidden();
});

it('PATCH /users/{user}: root/admin pueden cualquier usuario; standard solo a sí mismo', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $u1 = User::factory()->create();
    $u1->assignRole('standard');

    $u2 = User::factory()->create();
    $u2->assignRole('standard');

    $this->actingAs($root)->patch("/users/{$u1->id}", [
        'name' => $u1->name,
        'email' => $u1->email,
        'password' => '',
    ])->assertRedirect("/users/{$u1->id}");

    $this->actingAs($admin)->patch("/users/{$u2->id}", [
        'name' => $u2->name,
        'email' => $u2->email,
        'password' => '',
    ])->assertRedirect("/users/{$u2->id}");

    $this->actingAs($u1)->patch("/users/{$u1->id}", [
        'name' => $u1->name,
        'email' => $u1->email,
        'password' => '',
    ])->assertRedirect("/users/{$u1->id}");

    $this->actingAs($u1)->patch("/users/{$u2->id}", [
        'name' => $u2->name,
        'email' => $u2->email,
        'password' => '',
    ])->assertForbidden();
});

it('DELETE /users/{user}: root/admin pueden eliminar a otros; nadie puede auto-eliminarse', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $u1 = User::factory()->create();
    $u1->assignRole('standard');

    $u2 = User::factory()->create();
    $u2->assignRole('standard');

    $this->actingAs($root)->delete("/users/{$u1->id}")->assertRedirect('/users');
    $this->actingAs($admin)->delete("/users/{$u2->id}")->assertRedirect('/users');

    $this->actingAs($admin)->delete("/users/{$admin->id}")->assertForbidden();

    // Self-delete debe estar prohibido. Usamos un usuario nuevo no eliminado.
    $u3 = User::factory()->create();
    $u3->assignRole('standard');
    $this->actingAs($u3)->delete("/users/{$u3->id}")->assertForbidden();
});
