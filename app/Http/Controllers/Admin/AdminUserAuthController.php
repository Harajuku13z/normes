<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session('elizo_adminuser')) {
            return redirect()->route('admin.adminuser.index');
        }

        return view('admin.adminuser.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $ok = hash_equals(
            (string) $request->input('password'),
            (string) config('admin.elizo_adminuser_password')
        );

        if (! $ok) {
            return back()
                ->withErrors(['password' => 'Mot de passe incorrect.'])
                ->onlyInput('password');
        }

        $request->session()->regenerate();
        $request->session()->put('elizo_adminuser', true);

        return redirect()->route('admin.adminuser.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('elizo_adminuser');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.adminuser.login');
    }
}

