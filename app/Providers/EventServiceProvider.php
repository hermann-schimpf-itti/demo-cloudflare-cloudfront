<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nwidart\Modules\Facades\Module;

final class EventServiceProvider extends ServiceProvider {

    public function shouldDiscoverEvents(): bool {
        return true;
    }

    protected function discoverEventsWithin(): array {
        return [
            $this->app->path('Listeners'),
            ...array_map(
                callback: static fn ($module) => sprintf('%s/%s/Listeners',
                    config('modules.paths.modules'), $module->getName(),
                ),
                array: Module::allEnabled()
            ),
        ];
    }

}
