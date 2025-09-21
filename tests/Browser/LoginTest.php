<?php

declare(strict_types=1);

use App\Models\User;

it('may login', function () {
    $user = User::factory()->create();

    visit(route('login'))
        ->type('email', $user->email)
        ->type('password', 'password')
        ->press('Log in')
        ->assertSee('Dashboard')
        ->assertUrlIs(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});
