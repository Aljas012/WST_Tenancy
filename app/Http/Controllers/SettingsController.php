<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Tenant;
use App\Notifications\SubscriptionUpgradeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Notification;

use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Schema::hasTable('settings') ? Settings::first() : null;
        $subscription = null;

        $currentTenantId = tenancy()->tenant->id ?? null;

        // dd($currentTenantId);
        if ($currentTenantId) {
            $centralTenant = Tenant::find($currentTenantId);
            // dd($centralTenant);

            if ($centralTenant) {
                $rawSubscription  = $centralTenant->subscription ?? 'No Subscription';

                if (in_array(strtolower($rawSubscription), ['month', 'year', 'monthly', 'yearly'])) {
                    $subscription = 'Premium';
                } elseif ($rawSubscription) {
                    $subscription = $rawSubscription;
                }
            }
        }

        return view('tenantApp.settings', compact('settings', 'subscription'));
    }

    public function updateColor(Request $request)
    {

        $validated = $request->validate([
            'color' => 'required|string',
        ]);

        $settings = Settings::first();

        if (!$settings) {

            $settings = new Settings();
        }

        $settings->color = $validated['color'];
        $settings->save();

        return response()->json(['message' => 'Color updated successfully!']);
    }

    public function updateFont(Request $request)
    {
        $validated = $request->validate([
            'font' => 'required|string',
        ]);

        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        $settings->font = $validated['font'];
        $settings->save();

        return response()->json(['message' => 'Font updated successfully!']);
    }

    public function updateLayout(Request $request)
    {
        $validated = $request->validate([
            'layout' => 'required|string|in:left-sidebar,right-sidebar',
        ]);

        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        $settings->layout = $validated['layout'] === 'right-sidebar' ? true : false;
        $settings->save();

        return response()->json(['message' => 'Layout updated successfully!']);
    }

    public function saveMenuOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
        ]);

        $settings = Settings::first();

        if (! $settings) {
            $settings = Settings::create([
                'color' => 'purple',
                'font' => 'poppins',
                'incentive_percentage' => null,
                'layout' => false,
                'menu_order' => $request->order,
            ]);

            return response()->json(['message' => 'Menu order created.']);
        }

        $settings->update([
            'menu_order' => $request->order,
        ]);

        return response()->json(['message' => 'Menu order saved.']);
    }

    public function updateIncentive(Request $request)
    {
        // dd($request);
        $request->validate([
            'incentive_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $percentage = str_replace('%', '', $request->input('incentive_percentage'));

        $settings = Settings::first();
        if ($settings) {
            $settings->update([
                'incentive_percentage' => $percentage,
            ]);
        } else {
            // If no settings yet, create one
            Settings::create([
                'incentive_percentage' => $percentage,
            ]);
        }

        return back()->with('success', 'Incentive Percentage Updated Successfully!');
    }

    public function requestUpgrade(Request $request)
    {
        $tenantId = tenancy()->tenant->id ?? null;
        // dd($tenantId);

        if ($tenantId) {

            $centralTenant = Tenant::find($tenantId);
            // dd($centralTenant);

            if ($centralTenant) {

                Notification::route('mail', 'apsone069@gmail.com')
                    ->notify(new SubscriptionUpgradeRequest($centralTenant));

                return back()->with('success', 'Upgrade request sent successfully!');
            }
        }

        return back()->with('error', 'Tenant not found.');
    }
}
