<?php

declare(strict_types=1);

use App\Http\Controllers\TenantAppPageController;

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

});
