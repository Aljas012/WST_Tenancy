<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Car;
use App\Models\Mechanic;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;


class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = Maintenance::with(['car', 'mechanic.mechanicApplication'])
            ->orderBy('created_at', 'desc')
            ->get();

        $cars = Car::whereDoesntHave('maintenances', function ($query) {
            $query->whereIn('status', ['Under Maintenance', 'Done']);
        })->get();
        
        $mechanics = Mechanic::with('mechanicApplication')->get();

        return view('tenantApp.maintenance', compact('maintenances', 'cars', 'mechanics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request)
    {
        $validated = $request->validated();
        //dd($validated);
        $fixStartDate = new \DateTime();

        Maintenance::create([
            ...$validated,
            'fix_start' => $fixStartDate->format('F j, Y'),
            'fix_end' => 'TBA',
        ]);

        Car::where('id', $validated['car_id'])->update([
            'status' => 'Under Maintenance',
        ]);

        return back()->with('success', 'Car associated with Mechanic Successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequest $request, $maintenance)
    {
        $validated = $request->validated();
        $validated['fix_end'] = now()->format('F j, Y');

        $slctdMaintenance = Maintenance::findOrFail($maintenance);
        //dd($slctdMaintenance);
        
        $slctdMaintenance->update($validated);
        $slctdMaintenance->save();

        Car::where('id', $slctdMaintenance->car_id)->update([
            'status' => 'Done'
        ]);

        return back()->with('success', 'Maintenance Done Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $maintenance = Maintenance::findOrfail($id);
        $maintenance->delete();

        return response()->json(['dSuccess' => 'Maintenance Removed Successfully!']);
    }
}
