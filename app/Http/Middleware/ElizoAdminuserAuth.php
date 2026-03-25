<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ElizoAdminuserAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('elizo_adminuser')) {
            return $next($request);
        }

        return redirect()->route('admin.adminuser.login');
    }
}

