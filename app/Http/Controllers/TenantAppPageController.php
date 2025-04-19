<?php

namespace App\Http\Controllers;

use App\Models\TenantAppPage;
use App\Models\MechanicApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\StoreTenantAppPageRequest;
use App\Http\Requests\StoreTenantAuthRequest;
use App\Http\Requests\UpdateTenantAppPageRequest;

class TenantAppPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenant = tenant();

        return view('tenantAppLandingPage', compact('tenant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantAppPageRequest $request)
    {
        $validate = $request->validated();
        MechanicApplication::create($validate);

        return back()->with('success', 'Form Submitted Successfully!');
    }

    public function tenantLogin(StoreTenantAuthRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::guard('tenant')->user();

        if ($user->role === 'admin') {
            return redirect()->route('tenant_admin_dashboard');
        } else {
            return redirect()->route('tenant_user_dashboard');
        }
    }
}
