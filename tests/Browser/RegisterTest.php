<?php

declare(strict_types=1);

test('can register a user', function () {
    visit('/register')
        ->fill('username', 'testing')
        ->fill('email', 'test@gmail.com')
        ->fill('password', 'testing123')
        ->click('Create account')
        ->assertPathIs('/');
});
