<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\MechanicApplication;
use App\Http\Requests\StoreMechanicRequest;
use App\Http\Requests\UpdateMechanicRequest;

class MechanicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = MechanicApplication::orderBy('created_at', 'desc')->get();

        return view('tenantApp.mechanic', compact('mechanics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMechanicRequest $request)
    {
        $mechanicApplicationId = $request->input('mechanic_application_id');

        $mechanicApplication = MechanicApplication::find($mechanicApplicationId);
        $mechanicApplication->status = 'Active';
        $mechanicApplication->save();

        $mechanic = new Mechanic();
        $mechanic->mechanic_applicant_id = $mechanicApplication->id;
        $mechanic->save();

        return back()->with('success', 'Mechanic Approved Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mechanic $mechanic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mechanic $mechanic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMechanicRequest $request, $mechanic)
    {
        $mechanicApplication = MechanicApplication::findOrFail($mechanic);

        $mechanicApplication->update([
            'name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
        ]);

        return back()->with('success', 'Mechanic Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mechanic = MechanicApplication::findOrFail($id);
        $mechanic->delete();
    
        return response()->json(['dSuccess' => 'Mechanic deleted successfully!']);
    }
}
