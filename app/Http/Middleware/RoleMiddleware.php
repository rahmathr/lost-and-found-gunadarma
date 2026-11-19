<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $auth = $request->session()->get('auth');

        if (!$auth || !isset($auth['role'], $auth['id'])) {
            return redirect()->route('login');
        }

        if (!in_array($auth['role'], $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
