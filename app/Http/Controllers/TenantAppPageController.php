<?php

namespace App\Http\Controllers;

use App\Models\TenantAppPage;
use App\Http\Requests\StoreTenantAppPageRequest;
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TenantAppPage $tenantAppPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenantAppPage $tenantAppPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantAppPageRequest $request, TenantAppPage $tenantAppPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenantAppPage $tenantAppPage)
    {
        //
    }
}
