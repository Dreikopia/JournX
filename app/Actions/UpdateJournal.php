<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class UpdateJournal
{
    public function handle(array $attributes, $journal): void
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

        DB::transaction(function () use ($journal, $data, $attributes) {
            $journal->update($data);

            $journal->tasks()->delete();

            $journal->tasks()->createMany($attributes['tasks'] ?? []);
        });
    }
}
