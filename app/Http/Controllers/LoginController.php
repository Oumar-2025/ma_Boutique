<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 🔎 Chercher l’utilisateur par email
        $user = User::where('email', $request->email)->first();

        if ($user && $request->password === $user->plain_password) {
            // ✅ Connexion manuelle
            Auth::login($user);

            return redirect()->route('dashboard.index');
        }

        return back()->withErrors(['email' => 'Identifiants invalides']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.post');
    }
}
