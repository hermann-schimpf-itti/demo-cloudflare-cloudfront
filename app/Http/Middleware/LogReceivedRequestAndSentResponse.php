<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

final class LogReceivedRequestAndSentResponse {

    /**
     * @throws JsonException
     */
    public function handle(Request $request, Closure $next): Response {
        if (! config('app.debug')) {
            return $next($request);
        }

        $uuid = defined('LARAVEL_UUID') ? LARAVEL_UUID : Str::uuid()->toString();

        ($logger = Log::channel(isset($_SERVER['LAMBDA_TASK_ROOT']) ? 'stderr' : 'requests'))
            ->debug(sprintf('[%s] ==> %s %s <%s@%s>', $uuid, $request->getMethod(), urldecode($request->getRequestUri()),
                $request->user() ? sprintf('%u:%s', $request->user()->id, substr(md5($request->user()->toJson()), 0, 8)) : 'anonymous',
                $request->server->get('HTTP_USER_AGENT') ?? $request->server->get('REMOTE_ADDR') ?? 'unknown',
            ));

        if ($request->method() !== 'GET') {
            $fields = array_filter($request->all(), static fn (string $key) => ! in_array($key, $request->files->keys(), true), ARRAY_FILTER_USE_KEY);
            array_walk($fields, static fn (&$value, $key) => $value = in_array($key, [ 'password', 'access_token', 'pin' ], true) ? str_repeat('*', min(strlen($value), 16)) : $value);

            $logger->debug(sprintf('[%s] ==> %s', $uuid, json_encode($fields, JSON_THROW_ON_ERROR)));
        }

        foreach ($request->files as $filename => $file) {
            $logger->debug(sprintf('[%s] ==> %s %s %s %s', $uuid, $filename, $file->getMimeType(), $file->getClientOriginalName(), bytes2human($file->getSize())));
        }

        $start = microtime(true);

        $response = $next($request);

        $elapsed = number_format(microtime(true) - $start, 2);

        $logger->debug(sprintf('[%s] <== %sms %s %s', $uuid, $elapsed, $response->getStatusCode(), $response->getContent()));

        return $response;
    }

}
