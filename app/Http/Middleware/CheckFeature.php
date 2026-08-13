<?php

namespace App\Http\Middleware;

use App\Models\Feature;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeature
{
    /**
     * Usage in routes: ->middleware('feature:comments')
     * If the feature is off, the route behaves as if it doesn't exist (404) -
     * this matches how a genuinely unpurchased/unlicensed feature should feel,
     * rather than showing a "you're not allowed" message for something the
     * customer was never meant to see in the first place.
     */
    public function handle(Request $request, Closure $next, string $key): Response
    {
        if (!Feature::enabled($key)) {
            abort(404);
        }

        return $next($request);
    }
}
