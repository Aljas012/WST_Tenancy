<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Settings;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (tenancy()) {
                $view->with('tenant', tenant());

                $view->with('settings', Settings::first());
            }
        });

        // if (tenancy()->initialized) {
        //     if (app()->runningInConsole()) return;

        //     config([
        //         'mail.mailers.smtp.username' => 'tenant0690@gmail.com',
        //         'mail.mailers.smtp.password' => 'cnwvbkpdvdpjzbhv',
        //         'mail.from.address' => 'tenant0690@gmail.com',
        //         'mail.from.name' => 'Tenant App',
        //     ]);
        // }
    }
}
