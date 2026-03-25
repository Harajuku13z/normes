<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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

        $data = [
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email'),
            'password' => Hash::make((string) $request->input('password')),
        ];

        $hasIsAdmin = Schema::hasColumn('users', 'is_admin');
        if ($hasIsAdmin) {
            $data['is_admin'] = true;
        }

        $user = User::create($data);

        return redirect()
            ->route('admin.adminuser.index')
            ->with(
                'status',
                $hasIsAdmin
                    ? ('Admin créé : '.$user->name)
                    : ('Admin créé : '.$user->name.' (mais la colonne users.is_admin n\'existe pas sur cette DB : exécute php artisan migrate)')
            );
    }
}

