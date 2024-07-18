<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole {
    public function handle(Request $request, Closure $next, ...$roles): Response {

        $user_roles = [
            1 => 'admin',
            2 => 'user',
            3 => 'health_worker',
        ];

        $user_role = $user_roles[Auth::user()->user_role_id] ?? 'unknown role';

        if (!Auth::check() || !in_array($user_role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
