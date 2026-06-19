<?php

use App\Models\Journal;
use App\Models\User;

it('must be signed in to create a journal', function () {
    $journal = Journal::factory()->create();

    $this->get(route('journal.show', $journal))->assertRedirectToRoute('login');
});

test('it disallows non auth user to view other user journal throw not found', function () {

    $user = User::factory()->create();

    $this->ActingAs($user);

    $journal = Journal::factory()->create();

    $this->get(route('journal.show', $journal))->assertNotFound();
});
