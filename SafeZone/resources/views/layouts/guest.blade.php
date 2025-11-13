<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='grad' x1='0%25' y1='0%25' x2='0%25' y2='100%25'><stop offset='0%25' style='stop-color:%2306b6d4;stop-opacity:1'/><stop offset='100%25' style='stop-color:%230891b2;stop-opacity:1'/></linearGradient></defs><path d='M50 10 L80 25 L80 55 Q80 70 50 85 Q20 70 20 55 L20 25 Z' fill='url(%23grad)'/><text x='50' y='60' font-family='Arial,sans-serif' font-size='32' font-weight='bold' fill='white' text-anchor='middle'>SZ</text></svg>">
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-950 via-slate-900 to-gray-950">
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-sm border border-slate-600/30 shadow-2xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
