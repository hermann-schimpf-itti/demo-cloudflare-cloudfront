<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class DatabaseLoggerServiceProvider extends ServiceProvider {

    public function boot(): void {
        if (! config('app.debug')) {
            return;
        }

        $uuid = defined('LARAVEL_UUID') ? LARAVEL_UUID : Str::uuid()->toString();

        DB::listen(static function ($query) use ($uuid) {
            // add params to query
            while (count($query->bindings)) {
                // find query params
                if (($pos = strpos($query->sql, '?')) !== false) {
                    // replace query param with binding
                    $query->sql = substr_replace($query->sql, (string) (is_string($value = array_shift($query->bindings))
                        // convert encoding if is a string
                        ? "'".mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1')."'" : $value
                    ), $pos, 1);
                }
            }
            // format query time
            $query_time = number_format($query->time, 2);

            // put query string into log
            Log::channel(isset($_SERVER['LAMBDA_TASK_ROOT']) ? 'stderr' : 'queries')
                ->debug(sprintf('[%s] <%s> %sms ==> %s', $uuid, $query->connectionName, $query_time, $query->sql));
        });
    }

}
