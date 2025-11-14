<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SafeZone') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><defs><linearGradient id='grad' x1='0%25' y1='0%25' x2='0%25' y2='100%25'><stop offset='0%25' style='stop-color:%2306b6d4;stop-opacity:1'/><stop offset='100%25' style='stop-color:%230891b2;stop-opacity:1'/></linearGradient></defs><path d='M50 10 L80 25 L80 55 Q80 70 50 85 Q20 70 20 55 L20 25 Z' fill='url(%23grad)'/><text x='50' y='60' font-family='Arial,sans-serif' font-size='32' font-weight='bold' fill='white' text-anchor='middle'>SZ</text></svg>">
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- MapLibre CSS & JS -->
        <link href="https://unpkg.com/maplibre-gl@3.6.1/dist/maplibre-gl.css" rel="stylesheet" />
        <script src="https://unpkg.com/maplibre-gl@3.6.1/dist/maplibre-gl.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
        <link 
          rel="stylesheet" 
          href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        />
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>


        <script>
            window.MAPTILER_KEY = "{{ env('MAPTILER_KEY') }}";
        </script>

        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
        <script>
            window.socket = io("http://localhost:6001");
        </script>

        @stack('scripts')


        <style>
            #map {
                width: 100%;
                height: 500px;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 10px rgba(0,0,0,0.2);
                position: relative;
            }
            .suggestions::-webkit-scrollbar {
                width: 6px;
            }
            .suggestions::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 3px;
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            @yield('footer')
            @include('layouts.footer')
        </div>
    </body>
</html>
