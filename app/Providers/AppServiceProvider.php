<?php

namespace App\Providers;

use App\Channels\DatabaseChannel;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations(); //ignaore default personnal access token migrations

        $this->loadMigrationsFrom([
            database_path('migrations/base'),

            database_path('migrations/v1/gourvernance/board_directors/administrators'),
            database_path('migrations/v1/gourvernance/board_directors/sessions'),

            database_path('migrations/v1/gourvernance/executive_management/directors'),
            database_path('migrations/v1/gourvernance/executive_management/management_committees'),

            database_path('migrations/v1/gourvernance/general_meeting'),

            database_path('migrations/v1/gourvernance/shareholder'),

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

            database_path('migrations/v1/transfer'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app->instance(IlluminateDatabaseChannel::class, new DatabaseChannel());
    }
}
