<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantInfo;
use App\Models\TenantApplication;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PausedTenant;
use App\Notifications\ResumeTenant;
use App\Notifications\UpdateSubsTenant;
use App\Notifications\DeleteTenant;

use App\Http\Requests\UpdateTenantInfoRequest;

class TenantInfoController extends Controller
{

    public function pause(Tenant $tenant)
    {
        $tenant->update(['paused' => true]);

        $tenantDStatus = TenantInfo::where('id', $tenant->id)->firstOrFail();
        $tenantDStatus->domain_status = 'Paused';
        $tenantDStatus->save();

        $tenantApplication = $tenantDStatus->tenantApplication;
        $tenantEmail = $tenantApplication->email;

        Notification::route('mail', $tenantEmail)
            ->notify(new PausedTenant($tenantApplication));

        return response()->json(['pSuccess' => 'Domain Paused Successfully!']);
    }

    public function resume(Tenant $tenant)
    {
        $tenant->update(['paused' => false]);

        $tenantDStatus = TenantInfo::where('id', $tenant->id)->firstOrFail();
        $tenantDStatus->domain_status = 'Active';
        $tenantDStatus->save();

        $tenantApplication = $tenantDStatus->tenantApplication;
        $tenantEmail = $tenantApplication->email;

        Notification::route('mail', $tenantEmail)
            ->notify(new ResumeTenant($tenantApplication));

        return response()->json(['rSuccess' => 'Domain Resumed Successfully!']);
    }

    public function updateSubscription(UpdateTenantInfoRequest $request, $tenant)
    {
        $requested = $request->validated();

        $tenancy = TenantApplication::findOrFail($tenant);
        $tenancy->subscription = $requested['subscription'];
        $tenancy->save();

        $start = new \DateTime();
        $end = null;

        if ($requested['subscription'] === 'Month') {
            $end = (clone $start)->add(new \DateInterval('P1M'));
        } elseif ($requested['subscription'] === 'Year') {
            $end = (clone $start)->add(new \DateInterval('P1Y'));
        }

        // Update tenantInfo if exists
        if ($tenantInfo = $tenancy->tenantInfo) {
            $tenantInfo->subscription_start_date = $start->format('F j, Y');
            $tenantInfo->subscription_end_date = $end ? $end->format('F j, Y') : null;
            $tenantInfo->save();
        }

        // Update the central Tenant model
        if ($tenantModel = Tenant::findOrFail($tenant)) {
            $tenantModel->subscription = $requested['subscription'];
            $tenantModel->subscription_start_date = $start->format('F j, Y');
            $tenantModel->subscription_end_date = $end ? $end->format('F j, Y') : null;
            $tenantModel->save();
        }

        Notification::route('mail', $tenancy->email)
            ->notify(new UpdateSubsTenant($tenancy));

        return response()->json(['sSuccess' => 'Subscription successfully updated.']);
    }

    public function delete($tenant)
    {
        $tenancy = TenantApplication::findOrFail($tenant);
        $tenant = Tenant::findOrFail($tenancy->id);

        $tenancy->delete();
        $tenant->delete();

        $tenantEmail = $tenancy->email;

        Notification::route('mail', $tenantEmail)
            ->notify(new DeleteTenant($tenancy));

        return response()->json(['dSuccess' => 'Tenant deleted successfully.']);
    }
}
