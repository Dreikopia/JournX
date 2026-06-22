<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\JournalMood;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'mood' => ['required', Rule::enum(JournalMood::class)],
            'description' => ['required', 'string'],
            'links' => ['nullable', 'array'],
            'links.*' => ['url', 'max:255'],
            'tasks' => ['nullable', 'array'],
            'tasks.*.description' => ['string', 'max:255'],
            'tasks.*.completed' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120000'],
        ];
    }
}
