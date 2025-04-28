<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Maintenance;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;

class InventoryController extends Controller
{

    public function index()
    {
        $maintenances = Maintenance::with(['car', 'mechanic.mechanicApplication'])
            ->orderBy('created_at', 'desc')
            ->get();

        $inventory = Inventory::all();
        return view('tenantApp.inventory', compact('inventory', 'maintenances'));
    }

    public function store(StoreInventoryRequest $request)
    {
        $validated = $request->validated();
        Inventory::create($validated);

        return back()->with('success', 'Item created successfully.');
    }

}
