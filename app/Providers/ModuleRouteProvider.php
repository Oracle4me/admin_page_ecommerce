<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ModuleRouteProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadModuleRoutes();
    }

    protected function loadModuleRoutes(): void
    {
        $modulesPath = app_path('Modules');

        if (!File::exists($modulesPath)) {
            return;
        }

        foreach (File::directories($modulesPath) as $module) {

            // API routes
            $apiRoute = $module . '/Routes/api.php';
            if (File::exists($apiRoute)) {
                Route::prefix('api')
                    ->middleware('api')
                    ->group($module.'/Routes/api.php');
            }

            // Web routes
            $webRoute = $module . '/Routes/web.php';
            if (File::exists($webRoute)) {
                Route::middleware('web')
                    ->group($webRoute);
            }
        }
    }
}
