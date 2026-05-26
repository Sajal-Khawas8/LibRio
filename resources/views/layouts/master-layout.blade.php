<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>Libgen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-client.header />

    @if (session()->has('success'))
    <x-shared.message type='success' />
    @elseif (session()->has('error'))
    <x-shared.message type='error' />
    @endif

    <main class="min-h-[calc(100vh-4rem-3.5rem)] space-y-8">
        @yield('main')
    </main>

    <x-client.footer />
</body>

</html>