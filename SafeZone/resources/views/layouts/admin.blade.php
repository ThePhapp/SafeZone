<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SafeZone') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- MapLibre -->
        <link href="https://cdn.jsdelivr.net/npm/maplibre-gl@3.6.1/dist/maplibre-gl.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/maplibre-gl@3.6.1/dist/maplibre-gl.js"></script>

        <!-- Turf.js -->
        <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

        <link 
          rel="stylesheet" 
          href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
        />
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>

        <script>
            window.MAPTILER_KEY = "{{ env('MAPTILER_KEY') }}";
        </script>

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
    <body class="font-sans antialiased bg-gray-900 text-slate-200">
        <div class="min-h-screen bg-gray-900">
            @include('layouts.admin-navigation')
            @hasSection('header')
                <header class="bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif
            <main class="bg-gray-900">
                @yield('content')
            </main>
            @yield('footer')
            @include('layouts.footer')
        </div>
    </body>
</html>
