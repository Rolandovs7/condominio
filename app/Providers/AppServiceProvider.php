<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Paginación Bootstrap 5 con vista personalizada (dark theme)
        Paginator::defaultView('vendor.pagination.bootstrap-5');
        Paginator::useBootstrapFive();

        // Locale de Carbon en español
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'es');

        // Timezone de MySQL sincronizado con Bolivia (-04:00)
        if (config('database.default') === 'mysql') {
            try {
                DB::statement("SET time_zone='-04:00'");
            } catch (\Exception $e) {
                // Ignorar si no se puede setear (SQLite, etc.)
            }
        }

        // Longitud de strings por defecto para migraciones
        Schema::defaultStringLength(191);
    }
}
