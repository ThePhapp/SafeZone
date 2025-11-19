<nav x-data="{ open: false, notificationOpen: false }" class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border-b border-slate-700/50 shadow-lg backdrop-blur-xl relative z-[9999]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-cyan-400/20 blur-xl rounded-full group-hover:bg-cyan-400/30 transition-all duration-300"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white group-hover:text-cyan-400 transition-colors duration-300">SafeZone</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('addresses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('addresses*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('My Addresses') }}
                    </a>
                    <a href="{{ route('alerts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('alerts*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        {{ __('Alert') }}
                    </a>
                    <a href="{{ route('emergency-routes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('emergency-routes*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        {{ __('Emergency Routes') }}
                    </a>
                    <a href="{{ route('disaster-monitor') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('disaster-monitor') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        {{ __('Disaster Monitor') }}
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:gap-4 sm:ms-6 relative z-50">
                <!-- Notification Bell with Dropdown -->
                <div class="relative">
                    <button @click="notificationOpen = !notificationOpen" class="relative inline-flex items-center p-2 text-slate-300 hover:text-cyan-400 hover:bg-slate-800/50 rounded-lg transition-all duration-200 group focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Notification Badge -->
                        @php
                            $userNotifications = Auth::user()->unreadNotifications()->take(5)->get();
                            $unreadCount = Auth::user()->unreadNotifications()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="notification-badge absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-slate-900">{{ $unreadCount }}</span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notificationOpen" @click.away="notificationOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-96 rounded-xl shadow-2xl bg-slate-800 border border-slate-700/50 ring-1 ring-black ring-opacity-5 overflow-hidden z-[9999]" style="display: none;">
                        <div class="py-2 max-h-96 overflow-y-auto">
                            <div class="px-4 py-3 border-b border-slate-700/50">
                                <h3 class="text-base font-semibold text-white">Notifications</h3>
                            </div>
                            
                            <div class="notification-dropdown-content">
                            @forelse($userNotifications as $notification)
                                @php
                                    $data = $notification->data;
                                    $alertId = $data['alert_id'] ?? null;
                                    $severity = $data['severity'] ?? 'low';
                                    $title = $data['title'] ?? 'New notification';
                                    $type = $data['type'] ?? 'alert';
                                @endphp
                                <div class="px-4 py-3 hover:bg-slate-700/50 transition-colors duration-150 border-b border-slate-700/30 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                                @if($severity === 'critical') bg-red-500/20
                                                @elseif($severity === 'high') bg-orange-500/20
                                                @elseif($severity === 'medium') bg-yellow-500/20
                                                @else bg-blue-500/20
                                                @endif">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 
                                                    @if($severity === 'critical') text-red-400
                                                    @elseif($severity === 'high') text-orange-400
                                                    @elseif($severity === 'medium') text-yellow-400
                                                    @else text-blue-400
                                                    @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm font-medium text-white truncate">{{ $title }}</p>
                                                @if(!$notification->read_at)
                                                    <span class="flex-shrink-0 w-2 h-2 bg-cyan-400 rounded-full"></span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-400 mt-1">
                                                <span class="capitalize">{{ ucfirst($type) }}</span> • 
                                                <span class="uppercase">{{ $severity }}</span>
                                            </p>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                @if($alertId)
                                                    <a href="{{ route('alerts.show', $alertId) }}" 
                                                       class="text-xs text-cyan-400 hover:text-cyan-300 font-medium hover:underline"
                                                       onclick="markNotificationAsRead(event, '{{ $notification->id }}')">
                                                        View details →
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm text-slate-400 mt-2">No new notifications</p>
                                </div>
                            @endforelse
                            </div>
                            
                            @if($userNotifications->count() > 0)
                                <div class="px-4 py-3 border-t border-slate-700/50">
                                    <a href="{{ route('alerts.index') }}" class="block text-center text-sm text-cyan-400 hover:text-cyan-300 font-medium">
                                        View all notifications
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-600/50 text-sm font-medium rounded-lg text-slate-200 bg-slate-800/50 hover:bg-slate-700/50 hover:border-cyan-400/50 hover:text-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-xl shadow-2xl bg-slate-800 border border-slate-700/50 ring-1 ring-black ring-opacity-5 overflow-hidden z-[9999]" style="display: none;">
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-cyan-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <div class="border-t border-slate-700/50 my-2"></div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-cyan-400 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Admin Dashboard') }}
                                </a>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-cyan-400 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ __('User Dashboard') }}
                                </a>
                            @endif
                            <div class="border-t border-slate-700/50 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 relative z-50">
                <div class="relative">
                    <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2 border border-cyan-500/50 text-sm font-medium rounded-lg text-cyan-400 bg-cyan-500/10 hover:bg-cyan-500/20 hover:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/50 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Đăng nhập</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 rounded-xl shadow-2xl bg-slate-800 border border-slate-700/50 ring-1 ring-black ring-opacity-5 overflow-hidden z-[9999]" style="display: none;">
                        <div class="py-2">
                            <a href="{{ route('register') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-cyan-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                {{ __('Register') }}
                            </a>
                            <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-cyan-400 transition-colors duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log In') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-cyan-400 hover:bg-slate-800/50 focus:outline-none focus:bg-slate-800/50 focus:text-cyan-400 transition-all duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-800/95 backdrop-blur-xl border-t border-slate-700/50">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('addresses.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('addresses*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('My Addresses') }}
            </a>
            <a href="{{ route('alerts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('alerts*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                {{ __('Alert') }}
            </a>
            <a href="{{ route('emergency-routes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('emergency-routes*') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                {{ __('Emergency Routes') }}
            </a>
            <a href="{{ route('disaster-monitor') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('disaster-monitor') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                {{ __('Disaster Monitor') }}
            </a>
        </div>

        <!-- Responsive Notification Bell -->
        @auth
            <div class="px-2 pt-2 pb-3 border-t border-slate-700/50">
                <a href="{{ route('alerts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium transition-all duration-200 {{ request()->routeIs('alerts.index') ? 'bg-cyan-400/10 text-cyan-400 border border-cyan-400/30' : 'text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    {{ __('Notifications') }}
                </a>
            </div>
        @endauth

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-slate-700/50">
            <div class="px-4 mb-3">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </a>
                @if (Auth::user() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Admin Dashboard') }}
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('User Dashboard') }}
                    </a>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-base font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
        @else
            <div class="pt-4 pb-1 border-t border-slate-700/50">
            <div class="px-4 mb-3">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-full bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-base text-white">Chào mừng!</div>
                        <div class="font-medium text-sm text-slate-400">Vui lòng đăng nhập</div>
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('register') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium text-slate-300 hover:text-cyan-400 hover:bg-slate-700/50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    {{ __('Register') }}
                </a>
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-base font-medium text-cyan-400 hover:text-cyan-300 hover:bg-cyan-500/10 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Log In') }}
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>

@auth
<script>
    // Real-time notification updates
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof io !== 'undefined' && window.socket) {
            const userId = {{ Auth::id() }};
            const userAddresses = @json(Auth::user()->addresses->map(function($addr) {
                return [
                    'lat' => $addr->latitude,
                    'lng' => $addr->longitude
                ];
            }));
            // Track realtime alerts to avoid flicker (badge jump then drop)
            window.pendingRealtimeAlerts = window.pendingRealtimeAlerts || new Set();
            window.lastRealtimeAlertAt = 0;

            // Listen for new alerts
            window.socket.on('alertCreated', function(alert) {
                window.lastRealtimeAlertAt = Date.now();
                if (alert && alert.id) {
                    pendingRealtimeAlerts.add(alert.id);
                }
                if (isUserNearAlert(alert, userAddresses)) {
                    showToastNotification(alert);
                    playNotificationSound();
                    updateBadgeAndDropdownFromAlert(alert);
                }
            });

            function isUserNearAlert(alert, addresses) {
                if (!alert.address || !addresses || addresses.length === 0) return false;
                
                const alertLat = parseFloat(alert.address.latitude);
                const alertLng = parseFloat(alert.address.longitude);
                const alertRadius = (parseFloat(alert.radius) || 0) + 1000; // Add 1km buffer

                return addresses.some(addr => {
                    if (!addr.lat || !addr.lng) return false;
                    const distance = calculateDistance(
                        parseFloat(addr.lat), 
                        parseFloat(addr.lng), 
                        alertLat, 
                        alertLng
                    );
                    return distance <= alertRadius;
                });
            }

            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000; // Earth radius in meters
                const φ1 = lat1 * Math.PI / 180;
                const φ2 = lat2 * Math.PI / 180;
                const Δφ = (lat2 - lat1) * Math.PI / 180;
                const Δλ = (lon2 - lon1) * Math.PI / 180;

                const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                         Math.cos(φ1) * Math.cos(φ2) *
                         Math.sin(Δλ/2) * Math.sin(Δλ/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

                return R * c;
            }

            function updateBadgeAndDropdownFromAlert(alert) {
                // Update badge immediately (increment by 1)
                const badge = document.querySelector('.notification-badge');
                window.optimisticUnreadCount = (window.optimisticUnreadCount || 0) + 1;
                if (badge) {
                    const currentCount = parseInt(badge.textContent) || 0;
                    badge.textContent = currentCount + 1;
                    badge.classList.remove('hidden');
                } else {
                    // Create badge if it doesn't exist
                    const bellButton = document.querySelector('button[\\@click="notificationOpen = !notificationOpen"]');
                    if (bellButton) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'notification-badge absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-slate-900';
                        newBadge.textContent = '1';
                        bellButton.appendChild(newBadge);
                    }
                }
                
                // Add new notification to dropdown immediately
                addNotificationToDropdown({
                    data: {
                        alert_id: alert.id,
                        severity: alert.severity,
                        title: alert.title,
                        type: alert.type
                    },
                    read_at: null,
                    created_at: new Date().toISOString()
                });
            }
            
            function addNotificationToDropdown(notification) {
                const dropdownContainer = document.querySelector('.notification-dropdown-content');
                if (!dropdownContainer) return;
                
                // Remove "no notifications" message if exists
                const emptyMessage = dropdownContainer.querySelector('.text-center');
                if (emptyMessage) {
                    dropdownContainer.innerHTML = '';
                }
                
                const data = notification.data;
                const alertId = data.alert_id || null;
                const severity = data.severity || 'low';
                const title = data.title || 'New notification';
                const type = data.type || 'alert';
                
                const severityColors = {
                    'critical': { bg: 'bg-red-500/20', text: 'text-red-400' },
                    'high': { bg: 'bg-orange-500/20', text: 'text-orange-400' },
                    'medium': { bg: 'bg-yellow-500/20', text: 'text-yellow-400' },
                    'low': { bg: 'bg-blue-500/20', text: 'text-blue-400' }
                };
                
                const colors = severityColors[severity] || severityColors['low'];
                
                const notificationHtml = `
                    <div class="px-4 py-3 hover:bg-slate-700/50 transition-colors duration-150 border-b border-slate-700/30">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center ${colors.bg}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ${colors.text}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-white truncate">${title}</p>
                                    <span class="flex-shrink-0 w-2 h-2 bg-cyan-400 rounded-full"></span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">
                                    <span class="capitalize">${type.charAt(0).toUpperCase() + type.slice(1)}</span> • 
                                    <span class="uppercase">${severity}</span>
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-slate-500">Just now</span>
                                    ${alertId ? `<a href="/alerts/${alertId}" class="text-xs text-cyan-400 hover:text-cyan-300 font-medium hover:underline">View details →</a>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Insert at the beginning of the dropdown
                dropdownContainer.insertAdjacentHTML('afterbegin', notificationHtml);
            }
            
            function updateNotificationBadge() {
                // Avoid flicker: if realtime alert just arrived (<1.2s) skip immediate DB sync
                // For permanent optimistic notifications, do not downgrade count.
                // Fetch updated notification list and count
                fetch('/api/notifications/list', {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update badge
                    const badge = document.querySelector('.notification-badge');
                    const optimistic = window.optimisticUnreadCount || 0;
                    const effectiveCount = Math.max(optimistic, data.unread_count);
                    if (badge) {
                        if (effectiveCount > 0) {
                            badge.textContent = effectiveCount;
                            badge.classList.remove('hidden');
                        } else {
                            badge.remove();
                        }
                    } else if (effectiveCount > 0) {
                        // Create badge if it doesn't exist
                        const bellButton = document.querySelector('button[\\@click="notificationOpen = !notificationOpen"]');
                        if (bellButton) {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'notification-badge absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-slate-900';
                            newBadge.textContent = effectiveCount;
                            bellButton.appendChild(newBadge);
                        }
                    }
                    
                    // Update dropdown list
                    updateNotificationDropdown(data.notifications);
                })
                .catch(error => console.error('Error updating notifications:', error));
            }
            
            function updateNotificationDropdown(notifications) {
                const dropdownContainer = document.querySelector('.notification-dropdown-content');
                if (!dropdownContainer) return;
                
                const severityColors = {
                    'critical': { bg: 'bg-red-500/20', text: 'text-red-400' },
                    'high': { bg: 'bg-orange-500/20', text: 'text-orange-400' },
                    'medium': { bg: 'bg-yellow-500/20', text: 'text-yellow-400' },
                    'low': { bg: 'bg-blue-500/20', text: 'text-blue-400' }
                };
                
                if (notifications.length === 0) {
                    dropdownContainer.innerHTML = `
                        <div class="px-4 py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm text-slate-400 mt-2">No new notifications</p>
                        </div>
                    `;
                    return;
                }
                
                let html = '';
                notifications.forEach(notification => {
                    const data = notification.data;
                    const alertId = data.alert_id || null;
                    const severity = data.severity || 'low';
                    const title = data.title || 'New notification';
                    const type = data.type || 'alert';
                    const colors = severityColors[severity] || severityColors['low'];
                    const isUnread = !notification.read_at;
                    const createdAt = formatTimeAgo(notification.created_at);
                    
                    html += `
                        <div class="px-4 py-3 hover:bg-slate-700/50 transition-colors duration-150 border-b border-slate-700/30 ${isUnread ? '' : 'opacity-60'}">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center ${colors.bg}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ${colors.text}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-medium text-white truncate">${title}</p>
                                        ${isUnread ? '<span class="flex-shrink-0 w-2 h-2 bg-cyan-400 rounded-full"></span>' : ''}
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1">
                                        <span class="capitalize">${type.charAt(0).toUpperCase() + type.slice(1)}</span> • 
                                        <span class="uppercase">${severity}</span>
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs text-slate-500">${createdAt}</span>
                                        ${alertId ? `<a href="/alerts/${alertId}" class="text-xs text-cyan-400 hover:text-cyan-300 font-medium hover:underline">View details →</a>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                dropdownContainer.innerHTML = html;
                // Clear pending realtime IDs that now exist in DB
                if (Array.isArray(notifications) && window.pendingRealtimeAlerts) {
                    notifications.forEach(n => {
                        if (n && n.id) {
                            window.pendingRealtimeAlerts.delete(n.id);
                        }
                    });
                }
            }
            
            function formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);
                
                if (seconds < 60) return 'Just now';
                if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
                if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
                if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
                if (seconds < 2592000) return Math.floor(seconds / 604800) + ' weeks ago';
                return Math.floor(seconds / 2592000) + ' months ago';
            }

            function showToastNotification(alert) {
                const severityColors = {
                    'critical': 'bg-red-500',
                    'high': 'bg-orange-500',
                    'medium': 'bg-yellow-500',
                    'low': 'bg-blue-500'
                };
                
                const color = severityColors[alert.severity] || 'bg-blue-500';
                
                const toast = document.createElement('div');
                toast.className = `fixed top-20 right-4 ${color} text-white px-6 py-4 rounded-lg shadow-2xl z-[10000] max-w-md transform transition-all duration-300 ease-in-out`;
                toast.style.transform = 'translateX(400px)';
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-bold text-sm mb-1">${alert.title}</h4>
                            <p class="text-xs opacity-90">${alert.severity.toUpperCase()} - ${alert.type}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                // Animate in
                setTimeout(() => {
                    toast.style.transform = 'translateX(0)';
                }, 10);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.style.transform = 'translateX(400px)';
                    setTimeout(() => toast.remove(), 300);
                }, 10000);
            }

            function playNotificationSound() {
                // Create simple notification sound
                try {
                    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    oscillator.frequency.value = 800;
                    oscillator.type = 'sine';
                    
                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                    
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 0.5);
                } catch (error) {
                    console.log('Could not play notification sound:', error);
                }
            }
        }
    });
    
    // Mark notification as read when clicking "View details"
    window.markNotificationAsRead = function(event, notificationId) {
        event.preventDefault();
        const link = event.target.closest('a');
        
        fetch(`/api/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(() => window.location.href = link.href)
        .catch(() => window.location.href = link.href);
    };
</script>
@endauth
