<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;

class CreateJournal
{
    public function __construct(#[CurrentUser] protected User $user)
    {
        //
    }

    public function handle(array $attributes): void
    {
        $data = collect($attributes)->only([
            'title',
            'description',
            'mood',
            'links',
        ])->toArray();

        // single query to create journal with img already inluded

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('journals', 'public');
        }

        DB::transaction(function () use ($data, $attributes) {
            $journal = $this->user->journals()->create($data);

            $journal->tasks()->createMany($attributes['tasks'] ?? []);
        });
    }
}
