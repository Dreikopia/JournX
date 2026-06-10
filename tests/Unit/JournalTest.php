<?php

use App\Models\Journal;
use App\Models\User;

test('it belongs to user', function () {
    $journal = Journal::factory()->create();

    expect($journal->user)->toBeInstanceOf(User::class);
});

test('it can have tasks', function () {
    $journal = Journal::factory()->create();

    expect($journal->tasks)->toBeEmpty();

    $journal->tasks()->create([
        'description' => 'Bet to the knicks on game 4',
    ]);

    expect($journal->fresh()->tasks)->toHaveCount(1);
});
