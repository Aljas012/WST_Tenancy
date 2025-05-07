<?php

namespace App\Http\Controllers;


use App\Models\Mechanic;
use App\Models\MechanicApplication;
use App\Models\Tenant;
use App\Models\User;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Notifications\ApprovedMechanics;

use App\Http\Requests\StoreMechanicRequest;
use App\Http\Requests\UpdateMechanicRequest;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = MechanicApplication::orderBy('created_at', 'desc')->get();
        $mechanicCount = Mechanic::orderBy('created_at', 'desc')->get();

        $subscription = null;

        $currentTenantId = tenancy()->tenant->id ?? null;

        if ($currentTenantId) {
            $centralTenant = Tenant::find($currentTenantId);

            if ($centralTenant) {
                $rawSubscription  = $centralTenant->subscription ?? 'No Subscription';

                if (in_array(strtolower($rawSubscription), ['month', 'year', 'monthly', 'yearly'])) {
                    $subscription = 'Premium';
                } elseif ($rawSubscription) {
                    $subscription = $rawSubscription;
                }
            }
        }

        //dd($subscription);

        return view('tenantApp.mechanic', compact('mechanics', 'subscription', 'mechanicCount'));
    }

    public function store(StoreMechanicRequest $request)
    {
        $currentTenantId = tenancy()->tenant->id ?? null;

        if ($currentTenantId) {
            $centralTenant = Tenant::find($currentTenantId);

            if ($centralTenant) {
                $subscription = $centralTenant->subscription ?? 'No Subscription';

                if (strtolower($subscription) === 'free') {
                    if (Mechanic::count() >= 3) {
                        return back()->with('error', 'You already hit your free subscription :)');
                    }
                }
            }
        }

        $mechanicApplicationId = $request->input('mechanic_aapplication_id');

        $mechanicApplication = MechanicApplication::find($mechanicApplicationId);
        $mechanicApplication->status = 'Active';
        $mechanicApplication->save();

        $mechanic = new Mechanic();
        $mechanic->mechanic_applicant_id = $mechanicApplication->id;
        $mechanic->save();

        $mechanicEmail = $mechanicApplication->email;
        $name = $mechanicApplication->name;
        $password = Str::random(8);

        $user = User::create([
            'name' => $name,
            'email' => $mechanicEmail,
            'role' => 'user',
            'password' => Hash::make($password),
        ]);

        Notification::route('mail', $mechanicEmail)
            ->notify(new ApprovedMechanics($user, $password));


        return back()->with('success', 'Mechanic Approved Successfully!');
    }

    public function update(UpdateMechanicRequest $request, $mechanic)
    {
        $mechanicApplication = MechanicApplication::findOrFail($mechanic);

        $mechanicApplication->update([
            'name' => $request->input('full_name'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
        ]);

        return back()->with('success', 'Mechanic Updated Successfully!');
    }

    public function destroy($id)
    {
        $mechanic = MechanicApplication::findOrFail($id);
        $email = $mechanic->email;

        $mechanic->delete();

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->delete();
        }

        return response()->json(['dSuccess' => 'Mechanic Removed Successfully!']);
    }
}
