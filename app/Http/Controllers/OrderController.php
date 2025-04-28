<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\Maintenance;
use App\Models\Incentives;
use App\Models\Settings;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $orders = $request->input('orders');
        $maintenanceId = $request->input('car_id');

        $maintenance = Maintenance::with('mechanic')->find($maintenanceId);
        $mechanicId = $maintenance->mechanic->id ?? null;

        // 👉 Get the latest incentive percentage
        $defaultPercentage = Settings::first()->incentive_percentage ?? 0.05;

        foreach ($orders as $orderData) {
            $inventory = Inventory::where('part_number', $orderData['part_number'])->first();

            if ($inventory) {
                $order = Order::create([
                    'product_id'  => $inventory->id,
                    'mechanic_id' => $mechanicId,
                    'quantity'    => $orderData['quantity'],
                    'total'       => $orderData['total'],
                ]);

                $inventory->decrement('quantity', $orderData['quantity']);

                if ($inventory->quantity <= 0) {
                    $inventory->delete();
                }

                $incentiveAmount = $orderData['total'] * ($defaultPercentage / 100);

                Incentives::create([
                    'order_id'     => $order->id,
                    'mechanic_id'  => $order->mechanic_id,
                    'percentage'   => $defaultPercentage,
                    'incentive'    => $incentiveAmount,
                ]);
            }
        }

        return back()->with('success', 'Incentives Calculated Successfully!');
    }
}
