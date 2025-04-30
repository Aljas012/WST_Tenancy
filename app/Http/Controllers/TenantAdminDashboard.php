<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mechanic;
use App\Models\Car;
use App\Models\Maintenance;

class TenantAdminDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalMechanics = Mechanic::count();
        $totalCars = Car::count();
        $totalMaintenance = Maintenance::count();

        $mechanics = Mechanic::with(['maintenances', 'incentives', 'mechanicApplication'])->get();

        $mechanicSummaries = $mechanics->map(function ($mechanic) {
            $totalSalary = $mechanic->maintenances->sum(function ($maintenance) {
                return (float) str_replace(',', '', $maintenance->salary);
            });

            $totalIncentive = $mechanic->incentives->sum(function ($incentive) {
                return (float) $incentive->incentive;
            });

            return [
                'id' => $mechanic->id,
                'name' => optional($mechanic->mechanicApplication)->name ?? 'N/A',
                'total_salary' => $totalSalary,
                'total_incentive' => $totalIncentive,
            ];
        });

        return view('tenantApp.adminDashboard', compact(
            'totalMechanics',
            'totalCars',
            'totalMaintenance',
            'mechanicSummaries'
        ));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
