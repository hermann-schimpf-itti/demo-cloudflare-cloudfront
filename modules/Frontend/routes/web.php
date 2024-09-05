<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers;

/** # Web Routes of Frontend module */
Route::prefix(config('frontend.prefix'))->group(static function() {

    /** ## Unprotected routes */
    Route::get('/', [ Controllers\FrontendController::class, 'index' ]);

    /** ## Protected routes */
    Route::middleware('auth:'.config('frontend.guard'))->group(static function() {
        //
    });

});
