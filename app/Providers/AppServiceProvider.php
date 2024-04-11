<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom([
            // database_path('migrations/v1/gourvernance/board_directors/administrators'),
            // database_path('migrations/v1/gourvernance/board_directors/sessions'),

            // database_path('migrations/v1/gourvernance/general_meeting'),

            // database_path('migrations/v1/gourvernance'),

            // database_path('migrations/v1/guarantee/conventionnal_hypothecs'),

            // database_path('migrations/v1/alert'),

            // database_path('migrations/v1/litigation'),

            // database_path('migrations/v1/legal_watch'),

            database_path('migrations/v1/contract'),

            database_path('migrations/v1/bank'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
