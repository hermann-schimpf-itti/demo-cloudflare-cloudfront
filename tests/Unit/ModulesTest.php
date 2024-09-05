<?php

declare(strict_types=1);

use Nwidart\Modules\Facades\Module;

test('that all modules have at least one test', function () {
    expect($modules = Module::allEnabled())
        ->not()->toBeEmpty('No modules were defined');

    foreach ($modules as $module) {
        expect($module)
            ->toHaveUnitTests();
    }
});
