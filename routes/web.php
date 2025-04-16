<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantApplicationController;
use App\Http\Controllers\TenantInfoController;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {

        Route::get('/', function () {
            return view('centralAppLandingPage');
        });

        Route::get('/dashboard', [TenantApplicationController::class, 'index'])
            ->middleware(['auth', 'verified'])
            ->name('dashboard');

        Route::resource('tenant_application', TenantApplicationController::class);

        Route::middleware(['auth'])->group(function () {
            Route::post('/tenant/{tenant}/pause', [TenantInfoController::class, 'pause'])->name('tenant.pause');
            Route::post('/tenant/{tenant}/resume', [TenantInfoController::class, 'resume'])->name('tenant.resume');
            Route::post('/tenant/{tenant}/update_subscription', [TenantInfoController::class, 'updateSubscription'])->name('tenant.updateSubscription');
            Route::delete('/tenant/{tenant}/delete', [TenantInfoController::class, 'delete'])->name('tenant.destroy');
        });





        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
    });
}

require __DIR__ . '/auth.php';
