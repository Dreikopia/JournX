<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:8|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', Password::default()],
        ]);

        $user = User::create($validated);

        $request->session()->regenerate();
        Auth::login($user);

        return redirect('/')->with('success', 'Registration complete');
    }
}
