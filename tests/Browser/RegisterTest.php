<?php

declare(strict_types=1);

use App\Models\User;

test('can register a new user', function () {
    visit('/register')
        ->fill('username', 'testingnaten')
        ->fill('email', 'test@gmail.com')
        ->fill('password', 'testing123')
        ->click('@create-account')
        ->assertPathIs('/journal');

    expect(User::first())->not()->toBeNull();
});
