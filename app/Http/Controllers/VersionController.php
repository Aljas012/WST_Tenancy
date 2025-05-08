<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

use App\Models\Tenant;

use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function update(Request $request)
    {

        $latestVersion = session('latest_version');
        //dd($latestVersion);

        $tenantId = $request->input('tenant_id');
        $tenant = Tenant::find($tenantId);
        //dd($tenant);

        if ($tenant) {
            // Update the tenant's version
            $tenant->version = $latestVersion;
            $tenant->save();

            return back()->with('success', 'Tenant App updated to version ' . $latestVersion);
        } else {

            return back()->with('error', 'Tenant not found.');
            
        }
    }
}
