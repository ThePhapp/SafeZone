<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            {{ __('Alert Detail') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
        {{-- ====== Map Section ====== --}}
        <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-4">
            <div class="h-[400px] rounded-lg overflow-hidden">
                <x-map-alert :alerts="$alerts" :zoom="7" :user-addresses="$userAddresses" />
            </div>
        </div>

        {{-- ====== Main Content Grid ====== --}}
        <div class="grid lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Alert Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Title & Severity Card --}}
                <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
                    @php
                        $severity = strtolower($alerts[0]['severity'] ?? 'low');
                        $severityConfig = [
                            'critical' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-300', 'border' => 'border-red-500/30'],
                            'high' => ['bg' => 'bg-orange-500/20', 'text' => 'text-orange-300', 'border' => 'border-orange-500/30'],
                            'medium' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-300', 'border' => 'border-yellow-500/30'],
                            'low' => ['bg' => 'bg-cyan-500/20', 'text' => 'text-cyan-300', 'border' => 'border-cyan-500/30'],
                        ];
                        $config = $severityConfig[$severity] ?? $severityConfig['low'];
                    @endphp

                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                        <h3 class="text-2xl font-bold text-slate-100 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                            </svg>
                            {{ $alerts[0]['title'] ?? 'Untitled Alert' }}
                        </h3>

                        <span class="px-4 py-2 border rounded-lg text-sm font-bold uppercase {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                            {{ ucfirst($severity) }}
                        </span>
                    </div>

                    <p class="text-slate-400 text-sm">
                        <span class="font-semibold text-cyan-400">{{ ucfirst($alerts[0]['type'] ?? 'N/A') }}</span> • 
                        Issued at {{ $alerts[0]['created_at'] ?? '-' }}
                    </p>
                </div>

                {{-- Description Card --}}
                <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
                    <h4 class="font-semibold text-lg text-slate-100 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Description
                    </h4>
                    <p class="text-slate-300 leading-relaxed">
                        {{ $alerts[0]['description'] ?? 'No description provided.' }}
                    </p>
                </div>

                {{-- Image Card --}}
                @if(!empty($alerts[0]['image_path']))
                    <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-4">
                        <div class="w-full h-80 overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $alerts[0]['image_path']) }}"
                                 alt="Alert Image"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    </div>
                @endif

            </div>

            {{-- Right Column: Info Cards --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Status & Type Card --}}
                <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
                    <h4 class="font-semibold text-lg text-slate-100 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Alert Information
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Type</p>
                                <p class="text-slate-200">{{ ucfirst($alerts[0]['type'] ?? 'N/A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Status</p>
                                <p class="text-slate-200">{{ ucfirst($alerts[0]['status'] ?? 'Active') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Radius</p>
                                <p class="text-slate-200">{{ $alerts[0]['radius'] ?? '-' }} m</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline Card --}}
                <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
                    <h4 class="font-semibold text-lg text-slate-100 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Timeline
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Issued</p>
                                <p class="text-slate-200 text-sm">{{ $alerts[0]['created_at'] ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Updated</p>
                                <p class="text-slate-200 text-sm">{{ $alerts[0]['updated_at'] ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-400 uppercase font-semibold">Created By</p>
                                <p class="text-slate-200 text-sm">Admin {{ $alerts[0]['created_by'] ?? 'System' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Location Card --}}
                @if(!empty($alerts[0]['address']))
                    <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
                        <h4 class="font-semibold text-lg text-slate-100 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Location
                        </h4>
                        <div class="space-y-3">
                            <p class="text-slate-300 text-sm leading-relaxed">
                                {{ $alerts[0]['address']['formatted_address'] ?? 'No address available' }}
                            </p>
                            <div class="flex items-center gap-2 text-xs text-slate-400 bg-slate-900/50 p-2 rounded border border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>Lat: {{ $alerts[0]['address']['latitude'] ?? '-' }}, Lng: {{ $alerts[0]['address']['longitude'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>


        {{-- Back Button --}}
        <div class="text-center">
            <a href="{{ route('alerts.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-semibold rounded-lg shadow-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Alerts
            </a>
        </div>
    </div>
</x-app-layout>
