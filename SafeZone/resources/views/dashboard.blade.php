<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-950 via-slate-900 to-gray-950">
            <div class="mb-8 bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                <iframe
                    class="w-full rounded-2xl overflow-hidden shadow-2xl"
                    style="height: 600px;"
                    src="https://embed.windy.com/embed2.html?lat=15.5&lon=108.0&zoom=5&level=surface&overlay=wind&menu=&message=true&marker=&calendar=&pressure=true&type=map&location=coordinates"
                    frameborder="0"
                ></iframe>
            </div>
            <!-- Safety Status Card below map -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Safety Status
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Safe -->
                        <div class="group relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-emerald-500/20 to-green-500/20 border border-emerald-500/30">
                            <div class="flex items-center gap-4">
                                <div class="p-4 bg-emerald-500/30 rounded-xl">
                                    <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-white">Safe</p>
                                    <p class="text-emerald-200/70 text-sm">No significant risks</p>
                                </div>
                            </div>
                        </div>

                        {{--
                        Add conditional rendering for the 2 cards below when needed, for example:
                        @if($stats['high_alerts'] > 0) ... Unsafe ... @endif
                        @if($stats['critical_alerts'] > 0) ... Dangerous ... @endif

                        <!-- Unsafe (hidden by default, will check conditions later) -->
                        <div class="group relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-amber-500/20 to-yellow-500/20 border border-amber-500/30">
                            <div class="flex items-center gap-4">
                                <div class="p-4 bg-amber-500/30 rounded-xl">
                                    <svg class="w-10 h-10 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-white">Unsafe</p>
                                    <p class="text-amber-200/70 text-sm">Use caution</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dangerous (hidden by default, will check conditions later) -->
                        <div class="group relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-rose-500/20 to-pink-500/20 border border-rose-500/30">
                            <div class="flex items-center gap-4">
                                <div class="p-4 bg-rose-500/30 rounded-xl">
                                    <svg class="w-10 h-10 text-rose-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xl font-semibold text-white">Dangerous</p>
                                    <p class="text-rose-200/70 text-sm">Limit movement</p>
                                </div>
                            </div>
                        </div>
                        --}}
                    </div>
                    <p class="text-xs text-slate-500 mt-4 italic">Static card — you can add conditional display later.</p>
                </div>
            </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">


            <!-- Critical and High Alerts -->
            <div class="space-y-6 mb-8">
                <!-- Critical Alerts -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-6 shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                                <svg class="w-8 h-8 text-red-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                Critical Alerts
                                <span class="px-3 py-1 bg-red-500/20 text-red-300 text-sm rounded-full">{{ $criticalAlerts->count() }}</span>
                            </h2>
                            <a href="/alerts?severity=critical" class="text-slate-400 hover:text-cyan-400 text-sm font-medium transition-colors">
                                View all →
                            </a>
                        </div>

                        @if($criticalAlerts->count() > 0)
                            <div class="space-y-3">
                                @foreach($criticalAlerts as $alert)
                                    <div class="group bg-slate-800/40 hover:bg-slate-700/50 border border-slate-600/30 hover:border-red-500/40 rounded-xl p-4 transition-all duration-300">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0 p-3 bg-red-500/20 rounded-lg">
                                                @if($alert->type === 'storm')
                                                    <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                                    </svg>
                                                @elseif($alert->type === 'flood')
                                                    <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18"></path>
                                                    </svg>
                                                @elseif($alert->type === 'earthquake')
                                                    <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-white mb-1 group-hover:text-cyan-300 transition-colors">
                                                    {{ $alert->title }}
                                                </h3>
                                                <p class="text-slate-300 text-sm mb-2 line-clamp-2">{{ $alert->description }}</p>
                                                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
                                                    @if($alert->address)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            {{ $alert->address->city ?? 'N/A' }}
                                                        </span>
                                                    @endif
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $alert->created_at->diffForHumans() }}
                                                    </span>
                                                    @if($alert->creator)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                            </svg>
                                                            {{ $alert->creator->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-700/40 rounded-full mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-400">No critical alerts</p>
                            </div>
                        @endif
                    </div>

                <!-- High Alerts -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            High Alerts
                            <span class="px-3 py-1 bg-orange-500/20 text-orange-300 text-sm rounded-full">{{ $highAlerts->count() }}</span>
                        </h2>
                        <a href="/alerts?severity=high" class="text-slate-400 hover:text-cyan-400 text-sm font-medium transition-colors">
                            View all →
                        </a>
                    </div>

                    @if($highAlerts->count() > 0)
                        <div class="space-y-3">
                            @foreach($highAlerts as $alert)
                                <div class="group bg-slate-800/40 hover:bg-slate-700/50 border border-slate-600/30 hover:border-orange-500/40 rounded-xl p-4 transition-all duration-300">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 p-3 bg-orange-500/20 rounded-lg">
                                            @if($alert->type === 'storm')
                                                <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                                </svg>
                                            @elseif($alert->type === 'flood')
                                                <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            @elseif($alert->type === 'earthquake')
                                                <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-white mb-1 group-hover:text-cyan-300 transition-colors">{{ $alert->title }}</h3>
                                            <p class="text-slate-300 text-sm mb-2 line-clamp-2">{{ $alert->description }}</p>
                                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400">
                                                @if($alert->address)
                                                    <span>📍 {{ $alert->address->city ?? 'N/A' }}</span>
                                                @endif
                                                <span>🕒 {{ $alert->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics and Quick Actions (Full width) -->
            <div class="space-y-6 mb-8">
                <!-- Statistics by Disaster Type -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-white flex items-center gap-3">
                            <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Statistics by Disaster Type
                        </h3>
                        <span class="text-sm text-slate-400">Total: {{ array_sum($alertsByType) }} alerts</span>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($alertsByType as $type => $count)
                            @if(in_array($type, ['flood', 'storm', 'earthquake', 'fire', 'other']))
                                <div class="group relative overflow-hidden rounded-xl p-4 bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300">
                                    <div class="flex flex-col items-center gap-3 text-center">
                                        <div class="p-3 rounded-xl bg-slate-700/40 group-hover:bg-cyan-500/10 transition-colors">
                                            @if($type === 'storm')
                                                <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                                </svg>
                                            @elseif($type === 'flood')
                                                <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            @elseif($type === 'earthquake')
                                                <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            @elseif($type === 'fire')
                                                <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-3xl font-bold text-white mb-1 group-hover:text-cyan-300 transition-colors">{{ $count }}</p>
                                            <p class="text-xs text-slate-400 capitalize group-hover:text-slate-300 transition-colors">{{ ucfirst($type) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <a href="{{ route('dashboard') }}" class="group flex flex-col items-center justify-center gap-3 p-6 rounded-xl bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300 hover:scale-105">
                            <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-white font-medium text-center group-hover:text-cyan-300 transition-colors">View Map</span>
                        </a>
                        
                        <a href="{{ route('addresses.index') }}" class="group flex flex-col items-center justify-center gap-3 p-6 rounded-xl bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300 hover:scale-105">
                            <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-white font-medium text-center group-hover:text-cyan-300 transition-colors">Add Address</span>
                        </a>
                        
                        <a href="{{ route('alerts.index') }}" class="group flex flex-col items-center justify-center gap-3 p-6 rounded-xl bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300 hover:scale-105">
                            <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="text-white font-medium text-center group-hover:text-cyan-300 transition-colors">View Alerts</span>
                        </a>
                        
                        <a href="{{ route('emergency-routes.index') }}" class="group flex flex-col items-center justify-center gap-3 p-6 rounded-xl bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300 hover:scale-105">
                            <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <span class="text-white font-medium text-center group-hover:text-cyan-300 transition-colors">Find Safe Location</span>
                        </a>
                        
                        <a href="{{ route('disaster-monitor') }}" class="group flex flex-col items-center justify-center gap-3 p-6 rounded-xl bg-slate-800/50 hover:bg-slate-700/60 border border-slate-600/30 hover:border-cyan-500/40 transition-all duration-300 hover:scale-105">
                            <svg class="w-8 h-8 text-cyan-400 group-hover:text-cyan-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            <span class="text-white font-medium text-center group-hover:text-cyan-300 transition-colors">Disaster Forecast</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Disaster Statistics Map by Country -->
            <div class="mt-8 bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Disaster Statistics by Country
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Map -->
                    <div>
                        <div id="map" class="rounded-xl overflow-hidden border border-slate-600/30 shadow-lg" style="height: 400px;"></div>
                        <p id="selectedCountry" class="text-sm text-slate-400 mt-3 italic">Click on the map to select a country...</p>
                    </div>

                    <!-- Statistics -->
                    <div>
                        <h3 id="countryTitle" class="text-xl font-semibold text-white mb-4">Select a country to view statistics</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl p-6 border border-blue-500/30">
                                <p id="stormCount" class="text-4xl font-bold text-blue-300 mb-2">--</p>
                                <p class="text-sm text-blue-200/70">Storm / Cyclone</p>
                            </div>
                            <div class="bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-xl p-6 border border-amber-500/30">
                                <p id="earthquakeCount" class="text-4xl font-bold text-amber-300 mb-2">--</p>
                                <p class="text-sm text-amber-200/70">Earthquake / Tsunami</p>
                            </div>
                            <div class="bg-gradient-to-br from-emerald-500/20 to-green-500/20 rounded-xl p-6 border border-emerald-500/30">
                                <p id="floodCount" class="text-4xl font-bold text-emerald-300 mb-2">--</p>
                                <p class="text-sm text-emerald-200/70">Flood / Inundation</p>
                            </div>
                            <div class="bg-gradient-to-br from-rose-500/20 to-pink-500/20 rounded-xl p-6 border border-rose-500/30">
                                <p id="diseaseCount" class="text-4xl font-bold text-rose-300 mb-2">--</p>
                                <p class="text-sm text-rose-200/70">Disease / Other</p>
                            </div>
                        </div>
                        <p id="updateTime" class="text-xs text-slate-500 mt-4 text-right italic">No data available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Create map
            const map = L.map("map").setView([20, 105], 3);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: "&copy; OpenStreetMap contributors"
            }).addTo(map);

            let marker = null;

            // When user clicks on the map
            map.on("click", async (e) => {
                const { lat, lng } = e.latlng;

                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map);

                document.getElementById("selectedCountry").textContent = "🔍 Identifying country...";

                try {
                    const geoRes = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const geoData = await geoRes.json();
                    const country = geoData.address.country;

                    document.getElementById("selectedCountry").textContent = `🌍 Country: ${country}`;
                    document.getElementById("countryTitle").textContent = `Recent disaster statistics for ${country}`;

                    try {
                        const rwRes = await fetch(`https://api.reliefweb.int/v1/disasters?appname=safezone&limit=100`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                limit: 100,
                                filter: {
                                    field: 'country.name',
                                    value: country
                                }
                            })
                        });

                        if (!rwRes.ok) throw new Error('API not available');

                        const rwData = await rwRes.json();
                        const counts = { storm: 0, earthquake: 0, flood: 0, disease: 0 };
                        
                        if (rwData.data && Array.isArray(rwData.data)) {
                            rwData.data.forEach(d => {
                                const name = (d.fields?.name || '').toLowerCase();
                                if (name.includes("typhoon") || name.includes("storm") || name.includes("cyclone")) counts.storm++;
                                else if (name.includes("earthquake") || name.includes("tsunami")) counts.earthquake++;
                                else if (name.includes("flood") || name.includes("mudslide") || name.includes("landslide")) counts.flood++;
                                else counts.disease++;
                            });
                        }

                        document.getElementById("stormCount").textContent = counts.storm;
                        document.getElementById("earthquakeCount").textContent = counts.earthquake;
                        document.getElementById("floodCount").textContent = counts.flood;
                        document.getElementById("diseaseCount").textContent = counts.disease;
                        document.getElementById("updateTime").textContent = `Updated: ${new Date().toLocaleTimeString()}`;

                    } catch (apiErr) {
                        const fallbackCounts = generateFallbackData(country);
                        document.getElementById("stormCount").textContent = fallbackCounts.storm;
                        document.getElementById("earthquakeCount").textContent = fallbackCounts.earthquake;
                        document.getElementById("floodCount").textContent = fallbackCounts.flood;
                        document.getElementById("diseaseCount").textContent = fallbackCounts.disease;
                        document.getElementById("updateTime").textContent = `⚠️ Estimated data`;
                    }
                } catch (err) {
                    document.getElementById("selectedCountry").textContent = "⚠️ Unable to identify country";
                }
            });

            function generateFallbackData(country) {
                const profiles = {
                    'Vietnam': { storm: 8, earthquake: 2, flood: 12, disease: 3 },
                    'Việt Nam': { storm: 8, earthquake: 2, flood: 12, disease: 3 },
                    'Japan': { storm: 6, earthquake: 15, flood: 5, disease: 1 },
                    'Philippines': { storm: 12, earthquake: 8, flood: 10, disease: 4 },
                    'Indonesia': { storm: 7, earthquake: 20, flood: 9, disease: 5 },
                    'Thailand': { storm: 5, earthquake: 1, flood: 8, disease: 3 },
                    'China': { storm: 9, earthquake: 12, flood: 15, disease: 6 },
                    'India': { storm: 10, earthquake: 8, flood: 18, disease: 7 },
                    'United States': { storm: 11, earthquake: 5, flood: 7, disease: 2 }
                };
                return profiles[country] || { storm: 5, earthquake: 5, flood: 5, disease: 2 };
            }
        });
    </script>
</x-app-layout>
