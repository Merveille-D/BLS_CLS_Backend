<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/V1/guarantee.php'))
                ->group(base_path('routes/V1/auth.php'))
                ->group(base_path('routes/V1/litigation.php'))
                ->group(base_path('routes/V1/legal_watch.php'))
                ->group(base_path('routes/V1/recovery.php'))
                ->group(base_path('routes/V1/alert.php'))
                ->group(base_path('routes/V1/transfer.php'))

                ->group(base_path('routes/V1/action_transfer.php'))
                ->group(base_path('routes/V1/audit.php'))
                ->group(base_path('routes/V1/bank.php'))
                ->group(base_path('routes/V1/config.php'))
                ->group(base_path('routes/V1/contract.php'))
                ->group(base_path('routes/V1/director.php'))
                ->group(base_path('routes/V1/evaluation.php'))
                ->group(base_path('routes/V1/incident.php'))
                ->group(base_path('routes/V1/mandate.php'))
                ->group(base_path('routes/V1/shareholder.php'))

                ->group(base_path('routes/V1/general_meeting/general_meeting.php'))
                ->group(base_path('routes/V1/general_meeting/attendance_general_meeting.php'))
                ->group(base_path('routes/V1/general_meeting/task_general_meeting.php'))

                ->group(base_path('routes/V1/session_administrator/session_administrator.php'))
                ->group(base_path('routes/V1/session_administrator/attendance_session_administrator.php'))
                ->group(base_path('routes/V1/session_administrator/task_session_administrator.php'))
                ->group(base_path('routes/V1/session_administrator/administrator.php'))

                ->group(base_path('routes/V1/management_committee/management_committee.php'))
                ->group(base_path('routes/V1/management_committee/attendance_management_committee.php'))
                ->group(base_path('routes/V1/management_committee/task_management_committee.php'))

                
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
