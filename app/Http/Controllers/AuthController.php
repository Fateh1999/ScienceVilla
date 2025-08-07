<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob' => ['required', 'date', 'before:today'],
            'country' => ['required', 'string', 'in:in,uk,us,ca,au'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user, true); // Remember user for extended period
        $user->update(['last_login_at' => now()]);

        return redirect()->route('home', ['country' => $user->country]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember', true); // Default to remember

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            Auth::user()->update(['last_login_at' => now()]);

            $country = Auth::user()->country ?? 'in';
            return redirect()->intended(route('home', ['country' => $country]));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
