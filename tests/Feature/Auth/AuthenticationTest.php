<?php

declare(strict_types=1);

use App\Models\User;

function throttleKeyFor(string $email, string $ip = '127.0.0.1'): string
{
    // Mirror LoginRequest::throttleKey()
    return Str::transliterate(Str::of($email)->lower().'|'.$ip);
}

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('login is throttled after too many attempts and returns throttle message', function () {
    $user = User::factory()->create(['email' => 'Üser@Example.com']); // include uppercase + diacritic to exercise transliterate+lower
    $email = $user->email; // form input will use this as-is
    $ip = '127.0.0.1';
    $key = throttleKeyFor($email, $ip);

    // Hit the limiter 5 times to exceed the threshold used in ensureIsNotRateLimited()
    for ($i = 0; $i < 5; $i++) {
        RateLimiter::hit($key);
    }

    // Now any login attempt should be blocked by ensureIsNotRateLimited()
    $response = $this->from('/login')->post('/login', [
        'email' => $email,
        'password' => 'password', // even with correct password, lockout should fire first
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors('email');

    // Optional: sanity-check there is a cooldown (availableIn > 0)
    expect(RateLimiter::availableIn($key))->toBeGreaterThan(0);
});

test('successful login clears the rate limiter attempts for the throttle key', function () {
    $user = User::factory()->create(['email' => 'MixedCaseEmail@example.com']);
    $email = $user->email;
    $ip = '127.0.0.1';
    $key = throttleKeyFor($email, $ip);

    // Simulate a couple of prior failed attempts (below the lockout threshold)
    RateLimiter::hit($key);
    RateLimiter::hit($key);

    // Verify we have attempts before logging in
    expect(RateLimiter::tooManyAttempts($key, 3))->toBeFalse(); // not locked yet
    // Now perform a successful login (this goes through LoginRequest::authenticate and should clear the key)
    $response = $this->post('/login', [
        'email' => $email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    // After success, the limiter is cleared
    // Using tooManyAttempts with max=1 is a simple way to verify attempts were reset to 0
    expect(RateLimiter::tooManyAttempts($key, 1))->toBeFalse()
        ->and(RateLimiter::availableIn($key))->toBe(0);
});
