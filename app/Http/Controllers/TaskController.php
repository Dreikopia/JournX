<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;

class TaskController extends Controller
{
    public function update(Task $task)
    {
        $task->update(['completed' => ! $task->completed]);

        return back();
    }
}
