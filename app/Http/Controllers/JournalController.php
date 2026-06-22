<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateJournal;
use App\Actions\UpdateJournal;
use App\Http\Requests\JournalRequest;
use App\JournalMood;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $mood = $request->mood;

        if (! in_array($mood, JournalMood::values())) {
            $mood = null;
        }

        $journals = $user->journals()->when($mood, fn ($query, $mood) => $query->where('mood', $mood))
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

    public function store(JournalRequest $request, CreateJournal $action)
    {

        $action->handle($request->safe()->all());

        return to_route('journal.index')
            ->with('success', 'Journal Created');
    }

    public function show(Journal $journal)
    {
        Gate::authorize('modify', $journal); // authorization policy

        // Authorization
        return view('journal.show', [
            'journal' => $journal,
        ]);
    }

    public function edit(Journal $journal): void
    {
        Gate::authorize('modify', $journal);
    }

    public function update(JournalRequest $request, Journal $journal, UpdateJournal $action)
    {
        Gate::authorize('modify', $journal);

        $action->handle($request->safe()->all(), $journal);

        return back()->with('success', 'journal updated');
    }

    public function destroy(Journal $journal)
    {
        Gate::authorize('modify', $journal);

        $journal->delete();

        return to_route('journal.index');
    }
}
