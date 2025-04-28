<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\TenantAppPageController;
use App\Http\Controllers\TenantAdminDashboard;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\IncentivesController;
use App\Http\Controllers\SettingsController;

use App\Http\Controllers\TenantUserDashboard;

use Illuminate\Support\Facades\Route;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\PauseDomain;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    PauseDomain::class,
])->group(function () {
    Route::get('/', [TenantAppPageController::class, 'index']);

    Route::resource('tenant_app', TenantAppPageController::class);
    Route::post('tenant_login', [TenantAppPageController::class, 'tenantLogin'])->name('tenant_login');

    Route::middleware(['auth:tenant', 'role:admin'])->group(function () {
        Route::get('/admin', [TenantAdminDashboard::class, 'index'])->name('tenant_admin_dashboard');

        // ROUTE SA MECHANIC MODULE
        Route::resource('/mechanic', MechanicController::class);
        Route::delete('/mechanic/{id}', [MechanicController::class, 'destroy'])->name('mechanic.destroy');

        // ROUTE SA CAR MODULE
        Route::resource('/car', CarController::class);

        // ROUTE SA MAINTENANCE MODULE
        Route::resource('/maintenance', MaintenanceController::class);

        // ROUTE SA INVENTORY MODULE
        Route::resource('/inventory', InventoryController::class);

        // ROUTE SA ORDER MODULE
        Route::resource('/order', OrderController::class);

        // ROUTE SA INCENTIVES MODULE
        Route::resource('/incentives', IncentivesController::class);

        // ROUTE SA SETTINGS MODULE
        Route::resource('/settings', SettingsController::class);
        Route::post('/settings/color', [SettingsController::class, 'updateColor']);
        Route::post('/settings/font', [SettingsController::class, 'updateFont']);
        Route::post('/settings/layout', [SettingsController::class, 'updateLayout']);
        Route::post('/settings/incentive', [SettingsController::class, 'updateIncentive'])->name('settings.updateIncentive');


        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });



    Route::middleware(['auth:tenant', 'role:user'])->group(function () {
        Route::get('/user', [TenantUserDashboard::class, 'index'])->name('tenant_user_dashboard');
    });
});
