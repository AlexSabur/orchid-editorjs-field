<?php

namespace AlexSabur\OrchidEditorJSField\Providers;

use Illuminate\Support\Facades\Route;
use Orchid\Platform\Dashboard;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{
    public function map()
    {
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/systems'))
            ->as('platform.')
            ->middleware(config('platform.middleware.private'))
            ->group(realpath(ServiceProvider::PACKAGE_PATH . '/routes/systems.php'));
    }
}
