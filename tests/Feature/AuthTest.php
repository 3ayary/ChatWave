<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('login', function () {

    beforeEach(function () {
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'test1234',
        ]);

    });

    test('login successfully', function () {
        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'test1234',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);
    });

});

describe('register', function () {

    test('register successfully', function () {
        $response = $this->postJson('/api/register', [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);
    });

});

describe('logout', function () {

    test('logout successfully', function () {

        $user = User::factory()->create();

        $token = $user->createToken('auth_token')->plainTextToken;
        $response = $this->withHeader('authorization', 'Bearer '.$token)->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
    });

});


describe('me', function () {

    test('get current user successfully', function () {

        $user = User::factory()->create();

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('authorization', 'Bearer '.$token)->getJson('/api/me');

        $response->assertStatus(200);
        $response->assertJsonStructure(['user']);
    });

});