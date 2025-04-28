<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = null;

        if (Schema::hasTable('settings')) {
            $settings = Settings::first();
        }
        
        return view('tenantApp.settings', compact('settings'));
    }

    public function updateColor(Request $request)
    {

        $validated = $request->validate([
            'color' => 'required|string',
        ]);

        $settings = Settings::first();

        if (!$settings) {

            $settings = new Settings();
        }

        $settings->color = $validated['color'];
        $settings->save();

        return response()->json(['message' => 'Color updated successfully!']);
    }

    public function updateFont(Request $request)
    {
        $validated = $request->validate([
            'font' => 'required|string',
        ]);

        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        $settings->font = $validated['font'];
        $settings->save();

        return response()->json(['message' => 'Font updated successfully!']);
    }

    public function updateLayout(Request $request)
    {
        $validated = $request->validate([
            'layout' => 'required|string|in:left-sidebar,right-sidebar',
        ]);

        $settings = Settings::first();

        if (!$settings) {
            $settings = new Settings();
        }

        $settings->layout = $validated['layout'] === 'right-sidebar' ? true : false;
        $settings->save();

        return response()->json(['message' => 'Layout updated successfully!']);
    }

    public function updateIncentive(Request $request)
    {
        // dd($request);
        $request->validate([
            'incentive_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $percentage = str_replace('%', '', $request->input('incentive_percentage'));

        $settings = Settings::first();
        if ($settings) {
            $settings->update([
                'incentive_percentage' => $percentage,
            ]);
        } else {
            // If no settings yet, create one
            Settings::create([
                'incentive_percentage' => $percentage,
            ]);
        }

        return back()->with('success', 'Incentive Percentage Updated Successfully!');
    }
}
