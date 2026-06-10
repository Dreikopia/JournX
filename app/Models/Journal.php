<?php

declare(strict_types=1);

namespace App\Models;

use App\JournalMood;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'mood' => JournalMood::class,
    ];

    protected $attributes = [
        'mood' => JournalMood::NEUTRAL,
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // each journal belongs to each user
    }

    public function tasks()
    {
        return $this->hasMany(Task::class); // a journal can have many tasks
    }
}
