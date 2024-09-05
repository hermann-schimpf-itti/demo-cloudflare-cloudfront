<?php declare(strict_types=1);

namespace Modules\Frontend\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider {

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    private string $moduleNamespace = 'Modules\Frontend\Http\Controllers';

    /**
     * Called before routes are registered.
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot(): void {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void {
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void {
        Route::middleware('web')
             ->namespace($this->moduleNamespace)
             ->group(module_path('Frontend', '/routes/web.php'));
    }

}
