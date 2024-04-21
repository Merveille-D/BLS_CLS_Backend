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
            database_path('migrations/base'),

            database_path('migrations/v1/gourvernance/board_directors/administrators'),
            database_path('migrations/v1/gourvernance/board_directors/sessions'),

            database_path('migrations/v1/gourvernance/executive_management/directors'),
            database_path('migrations/v1/gourvernance/executive_management/management_committees'),

            database_path('migrations/v1/gourvernance/general_meeting'),

            // database_path('migrations/v1/gourvernance/shareholder'),

            database_path('migrations/v1/gourvernance'),

            database_path('migrations/v1/guarantee/conventionnal_hypothecs'),

            database_path('migrations/v1/alert'),

            database_path('migrations/v1/litigation'),

            database_path('migrations/v1/legal_watch'),

            database_path('migrations/v1/contract'),

            database_path('migrations/v1/bank'),

            database_path('migrations/v1/incident'),

            database_path('migrations/v1/evaluation'),

            database_path('migrations/v1/audit'),

            database_path('migrations/v1/recovery'),
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
