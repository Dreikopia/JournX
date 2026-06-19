<?php

use App\Models\User;
use App\Models\Journal;

it('can create a journal', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/journal')
        ->click('@create-journal')
        ->fill('title', 'Example title')
        ->fill('description', 'Example description')
        ->click('@button-mood-bad')
        ->fill('@new-link', 'http://example.com')
        ->click('@button-mood-bad')
        ->fill('@new-task', 'Running')
        ->click('@submit-new-task-button')
        ->click('Create')
        ->assertPathIs('/journal');

    // Verify the journal was created in the database

    // Verify it belongs to the correct user
    expect($journal = $user->journals()->first())->toMatchArray([
        'title' => 'Example title',
        'description' => 'Example description',
        'mood' => 'bad',
    ]);

    expect($journal->tasks)->toHaveCount(1);
});
