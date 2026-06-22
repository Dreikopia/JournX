<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class JournalImageController extends Controller
{
    public function destroy(Journal $journal)
    {
        Gate::authorize('modify', $journal);

        Storage::disk('public')->delete($journal->image_path);

        $journal->update(['image_path' => null]);

        return back();
    }
}
