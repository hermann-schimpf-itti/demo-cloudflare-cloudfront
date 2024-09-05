<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware {

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array {
        return [
            ...parent::share($request),
            'route' => [
                'name' => fn () => $request->route()?->getName(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'auth' => [
                'user' => fn() => $request->user() ? [
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'email_validated' => $request->user()->hasVerifiedEmail(),
                ] : null,
            ],
        ];
    }

}
