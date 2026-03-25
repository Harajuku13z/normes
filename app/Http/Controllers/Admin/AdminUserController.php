<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('admin.adminuser.index', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email'),
            'password' => Hash::make((string) $request->input('password')),
            'is_admin' => true,
        ]);

        return redirect()
            ->route('admin.adminuser.index')
            ->with('status', 'Admin créé : '.$user->name);
    }
}

