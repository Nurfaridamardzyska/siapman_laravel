<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        /** @var User|null $user */
        $user = $request->user();

        if (! $user) {
            abort(401);
        }

        if (! in_array($user->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
