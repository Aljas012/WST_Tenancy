<?php

namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Resolvers\TenantResolver;

class PauseDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Allow requests for assets under /dist (relative to the public folder)
        if ($request->is('dist/css/*') || $request->is('dist/js/*') || $request->is('dist/images/*')) {
            return $next($request);
        }

        if (tenancy()->initialized && tenant()->paused) {
            return response()->view('tenantApp.404Page', [], 403);
        }

        return $next($request);
    }
}
