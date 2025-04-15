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
        if (tenancy()->initialized && tenant()->paused) {
            return response()->view('tenantApp.404Page', [], 403); // '404Page' is your blade file name (no .blade.php)
        }

        return $next($request);
    }
}
