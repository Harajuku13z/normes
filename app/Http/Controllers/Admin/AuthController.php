<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            if ((bool) (Auth::user()?->is_admin ?? false)) {
                return redirect()->route('admin.dashboard');
            }

            // Utilisateur connecté mais pas admin : on le déconnecte.
            Auth::logout();
            $request = request();
            if ($request) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
            return redirect()->route('admin.login');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = trim((string) $request->input('login'));

        $user = User::query()
            ->where('email', $login)
            ->orWhere('name', $login)
            ->first();

        if (! $user || ! Hash::check((string) $request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'Identifiants invalides.'])->onlyInput('login');
        }

        Auth::login($user);

        if (! (bool) ($user->is_admin ?? false)) {
            Auth::logout();

            return back()->withErrors(['password' => 'Accès admin refusé.'])->onlyInput('login');
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
