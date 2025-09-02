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

    actingAs($root)->get('/users')->assertOk();
    actingAs($admin)->get('/users')->assertOk();
    actingAs($standard)->get('/users')->assertForbidden();
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

    actingAs($root)->get("/users/{$u1->id}")->assertOk();
    actingAs($admin)->get("/users/{$u2->id}")->assertOk();

    actingAs($u1)->get("/users/{$u1->id}")->assertOk();
    actingAs($u1)->get("/users/{$u2->id}")->assertForbidden();
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

    actingAs($root)->patch("/users/{$u1->id}", [])->assertOk();
    actingAs($admin)->patch("/users/{$u2->id}", [])->assertOk();

    actingAs($u1)->patch("/users/{$u1->id}", [])->assertOk();
    actingAs($u1)->patch("/users/{$u2->id}", [])->assertForbidden();
});

it('DELETE /users/{user}: root/admin pueden eliminar a otros; nadie puede auto-eliminarse', function () {
    $root = User::factory()->create();
    $root->assignRole('root');

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $u1 = User::factory()->create();
    $u1->assignRole('standard');

    actingAs($root)->delete("/users/{$u1->id}")->assertOk();
    actingAs($admin)->delete("/users/{$u1->id}")->assertOk();

    actingAs($admin)->delete("/users/{$admin->id}")->assertForbidden();
    actingAs($u1)->delete("/users/{$u1->id}")->assertForbidden();
});
