<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

use App\Models\Tenant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Process;
use Symfony\Component\Process\Process;

class VersionController extends Controller
{
    public function update(Request $request)
    {

        $latestVersion = session('latest_version');
        //dd($latestVersion);

        $tenantId = $request->input('tenant_id');
        $tenant = Tenant::find($tenantId);
        //dd($tenant);

        if (!$tenant) {
            return back()->with('error', 'Tenant not found.');
        }

        try {

            $commands = [
                '"C:\Program Files\Git\bin\git.exe" fetch --all --tags',
                "\"C:\Program Files\Git\bin\git.exe\" checkout tags/{$latestVersion} -f",
                '"C:\Users\Aljas\.config\herd-lite\bin\composer.bat" install --no-dev --optimize-autoloader',
                '"C:\Users\Aljas\.config\herd-lite\bin\php.exe" artisan migrate --force',
                '"C:\Users\Aljas\.config\herd-lite\bin\php.exe" artisan config:clear',
                '"C:\Users\Aljas\.config\herd-lite\bin\php.exe" artisan cache:clear',
                '"C:\Users\Aljas\.config\herd-lite\bin\php.exe" artisan route:clear',
                '"C:\Users\Aljas\.config\herd-lite\bin\php.exe" artisan view:clear',
            ];

            foreach ($commands as $command) {
                $process = Process::fromShellCommandline($command);
                $process->setTimeout(300);
                $process->run(function ($type, $output) {
                    Log::info("Command Output: " . $output);
                });
            }

            //dd($commands);

            $tenant->version = $latestVersion;
            $tenant->save();

            return back()->with('success', "Tenant App updated to version {$latestVersion}.");
        } catch (\Throwable $e) {
            Log::error("Update failed: " . $e->getMessage());
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }
}
