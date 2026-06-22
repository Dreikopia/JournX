<?php

use App\Models\Journal;
use App\Models\User;

it('can create a journal', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/journal')
        ->click('@create-journal')
        ->fill('title', 'Example title')
        ->fill('description', 'Example description')
        ->click('@button-mood-bad')
        ->fill('@new-link', 'http://example.com')
        ->click('@submit-new-link-button')
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

it('it edits an existing journal', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $journal = Journal::factory()->for($user)->create();

    visit(route('journal.show', $journal))
        ->click('@edit-journal-button')
        ->fill('title', 'Example title')
        ->fill('description', 'Example description')
        ->click('@button-mood-bad')
        ->fill('@new-link', 'http://example.com')
        ->click('@submit-new-link-button')
        ->fill('@new-task', 'Running')
        ->click('@submit-new-task-button')
        ->click('Save Changes')
        ->assertRoute('journal.show', [$journal]);

    // Verify the journal was created in the database

    // Verify it belongs to the correct user
    expect($journal = $user->journals()->first())->toMatchArray([
        'title' => 'Example title',
        'description' => 'Example description',
        'mood' => 'bad',
        'links' => [$journal->links[0], 'http://example.com'],
    ]);

    expect($journal->tasks)->toHaveCount(1);
});
