<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Paginator::defaultView('vendor.pagination.lostfound');

        // Diagnostik sementara: catat durasi query pada dashboard tanpa bindings.
        DB::listen(function ($query): void {
            if (! request()->is('dashboard/admin', 'dashboard/satpam')) {
                return;
            }

            Log::info('Diagnostik query dashboard', [
                'path' => request()->path(),
                'duration_ms' => $query->time,
                'sql' => $query->sql,
            ]);
        });
    }
}
