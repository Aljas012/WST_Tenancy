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
use App\Http\Controllers\PDFController;

use App\Http\Controllers\TenantUserDashboard;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\VersionController;

use Illuminate\Support\Facades\Route;

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Middleware\PauseDomain;
use App\Http\Middleware\UseTenantMailConfig;
use App\Http\Middleware\CheckLatestVersion;


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
    UseTenantMailConfig::class,
    CheckLatestVersion::class,
])->group(function () {

    Route::get('/', [TenantAppPageController::class, 'index']);

    Route::resource('tenant_app', TenantAppPageController::class);
    Route::post('tenant_login', [TenantAppPageController::class, 'tenantLogin'])->name('tenant_login');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // TENANT ADMIN
    Route::middleware(['auth:tenant', 'role:admin'])->group(function () {
        Route::get('/admin', [TenantAdminDashboard::class, 'index'])->name('tenant_admin_dashboard');
        Route::get('/details/{id}', [TenantAdminDashboard::class, 'getMechanicDetails']);

        Route::post('/version', [VersionController::class, 'update'])->name('version.update');

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
        Route::post('/settings/upgrade', [SettingsController::class, 'requestUpgrade'])->name('settings.upgrade');
        Route::post('/settings/bug', [SettingsController::class, 'reportBug'])->name('settings.bug');
        Route::post('/settings/menuItem', [SettingsController::class, 'saveMenuOrder']);

        //ROUTE SA PDF
        Route::post('/generate-pdf', [PDFController::class, 'generatePDFReport'])->name('generate.pdf');
    });


    // TENANT USER
    Route::middleware(['auth:tenant', 'role:user'])->group(function () {
        Route::get('/user', [TenantUserDashboard::class, 'index'])->name('tenant_user_dashboard');
    });
});
