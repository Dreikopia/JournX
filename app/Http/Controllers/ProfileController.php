<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {

        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', Password::defaults()],
        ]);

        $originalEmail = $user->email;

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ?? $user->password, // if it sets update if not use the user password
        ]);

        // notify the user that the email is changed

        if ($originalEmail !== $request->email) {
            Notification::route('mail', $originalEmail)->notify(new EmailChanged($user, $originalEmail));
        }

        return back()->with('success', 'Profile Updated');
    }
}
