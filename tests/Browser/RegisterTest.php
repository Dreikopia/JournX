<?php

declare(strict_types=1);

test('can register a user', function () {
    visit('/register')
        ->fill('username', 'GigaNigga')
        ->fill('email', 'giga@gmail.com')
        ->fill('password', 'GigaNigga123')
        ->click('Create account')
        ->assertPathIs('/');
});
