<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Car;
use App\Models\Mechanic;
use App\Models\MechanicApplication;
use Illuminate\Support\Facades\Auth;

class TenantUserDashboard extends Controller
{

    public function index()
    {
        $email = Auth::user()->email;
        $mechanicApp = MechanicApplication::where('email', $email)->first();

        if (!$mechanicApp || !$mechanicApp->mechanic) {
            return view('tenantApp.userDashboard', [
                'servicedCars' => [],
                'totalSalary' => 0,
                'totalIncentive' => 0,
            ]);
        }

        $mechanic = $mechanicApp->mechanic;
        //dd($mechanic);

        $maintenances = $mechanic->maintenances()->with('car')->get();

        $servicedCars = $maintenances->map(function ($maintenance) {
            return [
                'id' => $maintenance->car->id,
                'brand' => $maintenance->car->brand,
                'model' => $maintenance->car->model,
                'date_ended' => $maintenance->fix_end,
                'salary' => $maintenance->salary,
            ];
        });
        //dd($servicedCars);

        $totalSalary = $maintenances->sum(function ($m) {
            return (float) str_replace(',', '', $m->salary);
        });

        //dd($maintenances->pluck('salary'));

        $totalIncentive = $mechanic->incentives->sum('incentive');

        return view('tenantApp.userDashboard', compact('servicedCars', 'totalSalary', 'totalIncentive'));
    }

}
