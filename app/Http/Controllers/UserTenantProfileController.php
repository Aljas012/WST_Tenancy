<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

use App\Http\Requests\UpdateTenantProfileRequest;
use App\Http\Requests\UpdateTenantPasswordRequest;

class UserTenantProfileController extends Controller
{
    public function index(Request $request): View
    {
        return view('tenantApp.userProfile', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateTenantProfileRequest $request, $id): RedirectResponse
    {
        //dd($id);
        $user = $request->user();
        $user->fill(['name' => $request->validated()['name']]);
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(UpdateTenantPasswordRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->password = Hash::make($request->nPassword);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
