<?php declare(strict_types=1);

namespace Modules\Frontend\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories;

final class FrontendServiceProvider extends ServiceProvider {

    private string $moduleName = 'Frontend';

    private string $moduleNameLower = 'frontend';

    public function register(): void {
        $this->registerConfig();
        $this->app->register(RouteServiceProvider::class);
    }

    public function provides() {
        return [];
    }

    public function boot(): void {
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerTranslations();
        $this->registerViews();
    }

    private function registerConfig(): void {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower
        );
    }

    private function registerTranslations() {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'resources/lang'));
        }
    }

    private function registerViews(): void {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }

}
