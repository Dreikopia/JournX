<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JournalPolicy
{
    public function modify(User $user, Journal $journal)
    {
        return $journal->user->is($user) ? Response::allow() : Response::denyAsNotFound();
    }
}
