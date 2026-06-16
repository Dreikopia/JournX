<?php

use App\Models\Journal;
use App\Models\User;

it('can create a journal', function () {
    $this->actingAs(User::factory()->create());

    visit('/journal')
        ->click('@create-journal')
        ->fill('title', 'Example title')
        ->fill('description', 'Example description')
        ->click('@button-mood-good')
        ->click('Create')
        ->assertPathIs('/journal');

    expect(Journal::first())->toMatchArray([
        'title' => 'Example title',
        'description' => 'Example description',
        'mood' => 'good',
    ]);
});
