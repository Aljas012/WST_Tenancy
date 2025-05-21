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

            $phpPath = 'C:\\Users\\Aljas\\.config\\herd-lite\\bin\\php.exe';
            $composerPath = 'C:\\Users\\Aljas\\.config\\herd-lite\\bin\\composer.bat';

            if (file_exists($phpPath)) {
                Log::error("PHP path not found: $phpPath");
            }

            if (file_exists($composerPath)) {
                Log::error("Composer path not found: $composerPath");
            }

            $commands = [
                '"C:\Program Files\Git\bin\git.exe" fetch --all --tags',
                "\"C:\Program Files\Git\bin\git.exe\" checkout tags/{$latestVersion} -f",
                "\"$composerPath\" install --no-dev --optimize-autoloader",
                "\"$phpPath\" artisan migrate --force",
                "\"$phpPath\" artisan config:clear",
                "\"$phpPath\" artisan cache:clear",
                "\"$phpPath\" artisan route:clear",
                "\"$phpPath\" artisan view:clear",
            ];

            foreach ($commands as $command) {
                $process = Process::fromShellCommandline($command);
                $process->setTimeout(300);
                $process->setWorkingDirectory(base_path());
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
