<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\MechanicApplication;
use App\Http\Requests\StoreMechanicRequest;
use App\Http\Requests\UpdateMechanicRequest;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = MechanicApplication::orderBy('created_at', 'desc')->get();

        return view('tenantApp.mechanic', compact('mechanics'));
    }

    public function store(StoreMechanicRequest $request)
    {
        $mechanicApplicationId = $request->input('mechanic_aapplication_id');

        $mechanicApplication = MechanicApplication::find($mechanicApplicationId);
        $mechanicApplication->status = 'Active';
        $mechanicApplication->save();

        $mechanic = new Mechanic();
        $mechanic->mechanic_applicant_id = $mechanicApplication->id;
        $mechanic->save();

        return back()->with('success', 'Mechanic Approved Successfully!');
    }

    public function update(UpdateMechanicRequest $request, $mechanic)
    {
        $mechanicApplication = MechanicApplication::findOrFail($mechanic);

        $mechanicApplication->update([
            'name' => $request->input('full_name'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
        ]);

        return back()->with('success', 'Mechanic Updated Successfully!');
    }

    public function destroy($id)
    {
        $mechanic = MechanicApplication::findOrFail($id);
        $mechanic->delete();

        return response()->json(['dSuccess' => 'Mechanic Removed Successfully!']);
    }
}
