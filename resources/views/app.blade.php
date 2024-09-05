<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <meta inertia head-key="description" name="description" content="Laravel">

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        {{-- Favicon --}}
        <link rel="icon" type="image/png" href="{{ Vite::asset('resources/assets/images/favicons/128x128.png') }}">

        {{-- Scripts --}}
        @routes
        @php
            $resources = [ 'resources/assets/js/app.ts', 'resources/assets/css/app.css' ];
            $module = explode('::', $page['component'] ?? null);
            $component = count($module) > 1
                ? sprintf('modules/%s/resources/vue/%s.vue', $module[0], $module[1])
                : sprintf('resources/vue/%s.vue', $page['component'] ?? null);
            if (file_exists($component)) {
                $resources[] = $component;
            }
        @endphp
        @vite($resources)
        @if (isset($page))
            @inertiaHead
        @endif
    </head>

    <body class="font-sans antialiased">
        @if (isset($page))
            @inertia
        @endif
    </body>
</html>
