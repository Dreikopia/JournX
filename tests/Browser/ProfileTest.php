<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

test('if guess cant edit profile', function () {
    $this->get(route('profile.edit'))->assertRedirect('/login');
});

it('authenticated user can edit profile', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('username', $user->username)
        ->fill('username', 'New username')
        ->fill('email', 'newexample@gmail.com')
        ->click('Save changes')
        ->assertSee('Profile updated');

    expect($user->fresh())->toMatchArray([
        'username' => 'New username',
        'email' => 'newexample@gmail.com',
    ]);
});

it('notifies the old user email if email is changed', function () {

    $user = User::factory()->create();
    $this->actingAs($user);

    Notification::fake();

    $originalEmail = $user->email;

    visit(route('profile.edit'))
        ->assertValue('username', $user->username)
        ->fill('email', 'new@example.com')
        ->click('Save changes')
        ->assertSee('Profile updated');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routes, $notifiable) => $notifiable->routes['mail'] === $originalEmail);
});
