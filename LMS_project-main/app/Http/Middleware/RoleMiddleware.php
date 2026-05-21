<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RoleMiddleware
 *
 * This middleware checks the authenticated user's role and allows access
 * only if the user matches one of the specified roles. Roles are defined
 * as strings on the users table (e.g., 'student', 'teacher', 'admin').
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (Response)  $next
     * @param  mixed ...$roles The allowed roles for this route
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // If no user is authenticated or the role isn't allowed, abort with 403
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}