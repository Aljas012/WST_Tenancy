<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Tenant;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->get();

        return view('tenantApp.car', compact('cars'));
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
    public function store(StoreCarRequest $request)
    {
        $currentTenantId = tenancy()->tenant->id ?? null;

        if ($currentTenantId) {
            $centralTenant = Tenant::find($currentTenantId);

            if ($centralTenant) {
                $subscription = $centralTenant->subscription ?? 'No Subscription';

                if (strtolower($subscription) === 'free') {
                    if (Car::count() >= 3) {
                        return back()->with('error', 'You already hit your free subscription :)');
                    }
                }
            }
        }

        $validated = $request->validated();
        Car::create($validated);

        return back()->with('success', 'Car Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, $car)
    {
        $car = Car::findOrfail($car);
        $car->update([
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'concern' => $request->input('concern'),
            'plate_number' => $request->input('plate_number'),
        ]);

        return back()->with('success', 'Car Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Car::findOrfail($id);
        $car->delete();

        return response()->json(['dSuccess' => 'Car Removed Successfully!']);
    }
}
