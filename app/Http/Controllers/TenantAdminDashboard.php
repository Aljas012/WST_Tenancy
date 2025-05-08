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

    public function getMechanicDetails($id)
    {
        $mechanic = Mechanic::with(['maintenances.car',  'incentives.order.product', 'mechanicApplication'])
            ->findOrFail($id);

        $application = optional($mechanic->mechanicApplication);

        $name = $application->name ?? 'N/A';
        $phone = $application->contact ?? 'N/A';
        $address = $application->address ?? 'N/A';

        $cars = $mechanic->maintenances->map(function ($maintenance) {
            return [
                'id' => $maintenance->id,
                'car_name' => optional($maintenance->car)->model ?? 'N/A',
                'salary' => $maintenance->salary,
            ];
        });

        $products = $mechanic->incentives->map(function ($incentive) {
            return [
                'id' => $incentive->id,
                'category' => optional($incentive->order->product)->category ?? 'N/A',
                'incentive' => $incentive->incentive,
            ];
        });

        return response()->json([
            'id' => $mechanic->id,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'cars' => $cars,
            'products' => $products,
        ]);
    }

}
