<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantApplication;

use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplyTenant;
use App\Notifications\ApprovedTenant;
use App\Notifications\RejectTenant;

use App\Http\Requests\StoreTenantApplicationRequest;
use App\Http\Requests\UpdateTenantApplicationRequest;

class TenantApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenant_application = TenantApplication::with('tenantInfo')->orderBy('id', 'desc')->get();
        return view('centralApp.dashboard', compact('tenant_application'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantApplicationRequest $request)
    {
        $validated = $request->validated();
        $tenantApplication = TenantApplication::create($validated);

        $tenantApplication->tenantInfo()->create([
            'subscription_start_date' => 'Not Yet Approved',
            'subscription_end_date' => 'Not Yet Approved',
            'application_status' => 'Pending',
            'domain_status' => 'Pending',
        ]);

        $tenantEmail = $tenantApplication->email;

        Notification::route('mail', $tenantEmail) 
        ->notify(new ApplyTenant($tenantApplication));

        return back()->with('success', 'Application Form Submitted Successfully!');
    }

    /**
     * APPROVE TENANT'S APPLICATION
     */
    public function update($id)
    {
        $tenant = TenantApplication::findOrFail($id);

        $subscriptionType = $tenant->subscription;

        $subscriptionStartDate = new \DateTime();
        if ($subscriptionType === 'Month') {
            $subscriptionEndDate = clone $subscriptionStartDate;
            $subscriptionEndDate->add(new \DateInterval('P1M'));
        } elseif ($subscriptionType === 'Year') {
            $subscriptionEndDate = clone $subscriptionStartDate;
            $subscriptionEndDate->add(new \DateInterval('P1Y'));
        } else {
            $subscriptionEndDate = null;
        }
        
        $tenant->tenantInfo()->update([
            'application_status' => 'Approved',
            'domain_status' => 'Active',
            'subscription_start_date' => $subscriptionStartDate->format('F j, Y'),
            'subscription_end_date' => $subscriptionEndDate ? $subscriptionEndDate->format('F j, Y') : null,
        ]);

        $newTenant = Tenant::create([
            'id' => $tenant->id,
            'domain' => $tenant->domain,
            'business' => $tenant->business,
            'full_name' => $tenant->full_name,
            'email' => $tenant->email,
            'subscription' => $tenant->subscription,
            'subscription_start_date' => $subscriptionStartDate->format('F j, Y'),
            'subscription_end_date' => $subscriptionEndDate ? $subscriptionEndDate->format('F j, Y') : null,
        ]);

        $newTenant->domains()->create([
            'domain' => $tenant->domain . '.localhost',
        ]);

        return back()->with('success', 'Tenant Approved Successfully!');
    }

    public function destroy($id)
    {
        $tenantApplication = TenantApplication::findOrFail($id);

        $tenantApplication->delete();

        $tenantEmail = $tenantApplication->email;

        Notification::route('mail', $tenantEmail) 
        ->notify(new RejectTenant($tenantApplication));

        return response()->json(['dSuccess' => 'Tenant Rejected successfully.']);
    }
}
