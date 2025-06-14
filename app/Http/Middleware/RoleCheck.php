<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role_id, $roles)) {
            // Show 404 if role doesn't match
            throw new NotFoundHttpException;
        }

        return $next($request);
    }
}
