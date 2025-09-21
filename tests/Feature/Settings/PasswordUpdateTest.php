<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;

test('password can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/password');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/settings/password');
});

test('password settings page renders with mustVerifyEmail and null status', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/settings/password');

    $response->assertStatus(200);

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('settings/password')
        ->where('mustVerifyEmail', $user instanceof Illuminate\Contracts\Auth\MustVerifyEmail)
        ->where('status', null)
    );
});

test('password settings page renders and passes session status', function () {
    $user = User::factory()->create();

    $response = $this
        ->withSession(['status' => 'password-updated'])
        ->actingAs($user)
        ->get('/settings/password');

    $response->assertStatus(200);

    $response->assertInertia(fn (AssertableInertia $page) => $page
        ->component('settings/password')
        ->where('mustVerifyEmail', $user instanceof Illuminate\Contracts\Auth\MustVerifyEmail)
        ->where('status', 'password-updated')
    );
});
