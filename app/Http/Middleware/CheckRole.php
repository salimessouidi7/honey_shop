<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Usage in routes: ->middleware('role:admin,staff')
     * Redirects to admin login if not authenticated,
     * aborts with 403 if authenticated but wrong role.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
