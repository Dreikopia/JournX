<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalRequest;
use App\Http\Requests\UpdateJournalRequest;
use App\JournalMood;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $mood = $request->mood;

        if (! in_array($mood, JournalMood::values())) {
            $mood = null;
        }

        $journals = $user->journals()->when($mood, fn($query, $mood) => $query->where('mood', $mood))
            ->latest()
            ->get();

        return view('journal.index', [
            'journals' => $journals,
            'moodCounts' => Journal::moodCounts($user),
        ]);
    }

    public function create(): void
    {
        //
    }

    public function store(StoreJournalRequest $request)
    {
        $journal = Auth::user()->journals()->create($request->safe()->except('tasks', 'image'));

        $journal->tasks()->createMany(
            collect($request->tasks ?? [])->map(fn($task) => ['description' => $task])
        );

        $image_path = $request->image->store('journals', 'public');

        $journal->update([
            'image_path' => $image_path
        ]);

        return to_route('journal.index')
            ->with('success', 'Journal Created');
    }

    public function show(Journal $journal)
    {
        //Authorization
        return view('journal.show', [
            'journal' => $journal,
        ]);
    }

    public function edit(Journal $journal): void
    {
        //
    }

    public function update(UpdateJournalRequest $request, Journal $journal): void
    {
        //
    }

    public function destroy(Journal $journal)
    {

        //Authorization
        $journal->delete($journal);

        return to_route('journal.index');
    }
}
