<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SessionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.session.create');
    }

    public function store(SessionRequest $request)
    {

        $validated = $request->validated();

        $user = User::where('email', $validated['login'])
            ->orWhere('username', $validated['login'])
            ->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withInput()
                ->withErrors([
                    'credentials' => 'The provided credentials are wrong',
                ]);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Welcome back '.ucfirst((string) Auth::user()->username));

    }

    public function destroy()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    }
}
