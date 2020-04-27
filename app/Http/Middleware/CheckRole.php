<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckRole {
    /**
     * Handle an incoming request by checking that a user has a particular role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $roleName
     * @return mixed
     */
    public function handle($request, Closure $next, $roleName)
    {
        // throws an exception if user doesn't have the proper role
        Gate::authorize('role', $roleName);

        return $next($request);
    }
}
