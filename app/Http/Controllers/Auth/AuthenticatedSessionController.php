<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'guru') {
    return redirect()->intended('/guru');
} elseif ($user->role === 'admin') {
    return redirect()->intended('/admin');
} elseif ($user->role === 'siswa') {
    return redirect()->intended('/');
};
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}