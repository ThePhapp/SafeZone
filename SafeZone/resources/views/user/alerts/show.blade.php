<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
            {{-- Heroicon: Bell Alert --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            {{ __('Alert Detail') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 py-8 space-y-8">
        {{-- ====== Map Section ====== --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-4">
            <div class="h-[500px] rounded-xl overflow-hidden">
                {{-- map expects a resource collection (transformed) in $alerts --}}
                <x-map-alert :alerts="$alerts" :zoom="7" :user-addresses="$userAddresses" />
            </div>
        </div>

        {{-- ====== Alert Detail Card ====== --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transition-all">

            {{-- Header: Title + Severity --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    {{-- Heroicon: Exclamation Circle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                    </svg>
                    {{ $alerts[0]['title'] ?? 'Untitled Alert' }}
                </h3>

                @php
                    $severity = strtolower($alerts[0]['severity'] ?? 'low');
                    $severityColors = [
                        'high' => 'bg-red-100 text-red-700 border-red-300',
                        'medium' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                        'low' => 'bg-green-100 text-green-700 border-green-300',
                    ];
                    $severityIcons = [
                        'high' => '🔥',
                        'medium' => '⚠️',
                        'low' => '✅',
                    ];
                @endphp

                <span class="px-4 py-1 border rounded-full text-sm font-semibold flex items-center gap-1
                    {{ $severityColors[$severity] ?? 'bg-gray-100 text-gray-700 border-gray-300' }}">
                    {{ $severityIcons[$severity] ?? 'ℹ️' }} {{ ucfirst($severity) }}
                </span>
            </div>

            {{-- Image --}}
            @if(!empty($alerts[0]['image_path']))
                <div class="w-full h-64 mb-6 overflow-hidden rounded-xl">
                    <img src="{{ asset('storage/' . $alerts[0]['image_path']) }}"
                         alt="Alert Image"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
            @endif

            {{-- Description --}}
            <div class="mb-6">
                <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-2 flex items-center gap-2">
                    {{-- Heroicon: Document Text --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V8l-6-6H8a2 2 0 00-2 2v16a2 2 0 002 2z" />
                    </svg>
                    Description
                </h4>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $alerts[0]['description'] ?? 'No description provided.' }}
                </p>
            </div>

            {{-- Info Grid with Icons --}}
            <div class="grid md:grid-cols-2 gap-6 text-gray-700 dark:text-gray-300">

                <div class="space-y-2">
                    <p class="flex items-center gap-2">
                        {{-- Type Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        <span class="font-semibold">Type:</span> {{ ucfirst($alerts[0]['type'] ?? 'N/A') }}
                    </p>

                    <p class="flex items-center gap-2">
                        {{-- Status Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2l4 -4m1 -2a9 9 0 11-6.219 2.781A8.978 8.978 0 0112 3z" />
                        </svg>
                        <span class="font-semibold">Status:</span> {{ ucfirst($alerts[0]['status'] ?? 'N/A') }}
                    </p>

                    <p class="flex items-center gap-2">
                        {{-- Radius Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2a10 10 0 100 20 10 10 0 000-20zM12 6v6l4 2" />
                        </svg>
                        <span class="font-semibold">Radius:</span> {{ $alerts[0]['radius'] ?? '-' }} m
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="flex items-center gap-2">
                        {{-- Issued At --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6 1A9 9 0 1112 3a9 9 0 019 9z" />
                        </svg>
                        <span class="font-semibold">Issued at:</span> {{ $alerts[0]['issued_at'] ?? '-' }}
                    </p>

                    <p class="flex items-center gap-2">
                        {{-- Created By --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A10.97 10.97 0 0112 15c2.485 0 4.773.81 6.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-semibold">Created by:</span> {{ $alerts[0]['created_by'] ?? '-' }}
                    </p>

                    <p class="flex items-center gap-2">
                        {{-- Updated At --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6 1A9 9 0 1112 3a9 9 0 019 9z" />
                        </svg>
                        <span class="font-semibold">Updated at:</span> {{ $alerts[0]['updated_at'] ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Address --}}
            @if(!empty($alerts[0]['address']))
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-100 mb-2 flex items-center gap-2">
                        {{-- Location Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z" />
                        </svg>
                        Address
                    </h4>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $alerts[0]['address']['formatted_address'] ?? 'No address available' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        (Lat: {{ $alerts[0]['address']['latitude'] ?? '-' }},
                         Lng: {{ $alerts[0]['address']['longitude'] ?? '-' }})
                    </p>
                </div>
            @endif
        </div>


        {{-- Back Button --}}
        <div class="text-center">
            <a href="{{ route('alerts.index') }}"
               class="inline-flex items-center gap-2 px-6 py-2 mt-4 bg-blue-600 text-white font-semibold rounded-xl shadow hover:bg-blue-700 transition">
                {{-- Left Arrow Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>
                Back to Alerts
            </a>
        </div>
    </div>
</x-app-layout>
