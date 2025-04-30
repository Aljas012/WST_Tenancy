<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UseTenantMailConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (tenancy()->initialized) {
            config([
                'mail.mailers.smtp.username' => 'tenant0690@gmail.com',
                'mail.mailers.smtp.password' => 'cnwvbkpdvdpjzbhv',
                'mail.from.address' => 'tenant0690@gmail.com',
                'mail.from.name' => 'Tenant App',
            ]);
        }

        return $next($request);
    }
}
