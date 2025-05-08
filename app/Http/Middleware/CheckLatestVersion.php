<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckLatestVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        Log::info('✅ CheckLatestVersion middleware is running.');

        if (!session()->has('latest_version')) {
            try {
                $response = Http::withoutVerifying()->get('https://api.github.com/repos/Aljas012/WST_Tenancy/releases/latest');

                if ($response->successful()) {
                    $latestVersion = $response->json()['tag_name'] ?? null;

                    if ($latestVersion) {
                        session(['latest_version' => $latestVersion]);
                        session()->save(); // Force save for testing
                        Log::info("✅ Latest version stored in session: {$latestVersion}");
                    } else {
                        Log::warning('⚠️ GitHub API returned success but no tag_name.');
                    }
                } else {
                    Log::error('❌ GitHub API request failed.');
                }
            } catch (\Exception $e) {
                Log::error('❌ Exception in CheckLatestVersion middleware: ' . $e->getMessage());
            }
        } else {
            Log::info('ℹ️ latest_version already in session.');
        }

        return $next($request);
    }
}
