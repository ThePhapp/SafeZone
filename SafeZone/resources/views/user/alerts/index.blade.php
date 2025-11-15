<x-app-layout>

    <style>
        @keyframes alert-border-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(236, 72, 72, 0.6);
                border-color: rgba(236, 72, 72, 0.8);
            }
            50% {
                box-shadow: 0 0 15px 4px rgba(236, 72, 72, 0.8);
                border-color: rgb(236, 72, 72);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(236, 72, 72, 0.6);
                border-color: rgba(236, 72, 72, 0.8);
            }
        }

        .alert-new {
            animation: alert-border-glow 1.5s ease-in-out infinite;
            transition: all 0.3s ease;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Disaster Alerts') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- MAP -->
        <div class="h-[500px] mb-6">
            {{-- map expects a resource collection (transformed) in $alerts --}}
            <x-map-alert :alerts="$alerts" :zoom="7" :user-addresses="$userAddresses" :is-admin="false" />
        </div>

        <!-- Content -->
        <div class="space-y-6">
            <!-- Mode Filter Buttons -->
<div class="flex justify-center mb-8 gap-4">
    <!-- All Alerts -->
    <a href="{{ route('alerts.index', ['mode' => 'all']) }}"
       class="px-6 py-3 rounded-lg font-semibold flex items-center gap-2 shadow-sm transition duration-300
              {{ $mode === 'all' 
                    ? 'bg-slate-700 text-white border-2 border-cyan-400 shadow-lg shadow-cyan-500/20' 
                    : 'bg-slate-800/50 border border-slate-600 text-slate-300 hover:bg-slate-700/50 hover:border-cyan-400/50' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5h18M3 12h18M3 19h18" />
        </svg>
        All Alerts
    </a>

    <!-- Near You -->
    <a href="{{ route('alerts.index', ['mode' => 'near']) }}"
       class="px-6 py-3 rounded-lg font-semibold flex items-center gap-2 shadow-sm transition duration-300
              {{ $mode === 'near' 
                    ? 'bg-slate-700 text-white border-2 border-cyan-400 shadow-lg shadow-cyan-500/20' 
                    : 'bg-slate-800/50 border border-slate-600 text-slate-300 hover:bg-slate-700/50 hover:border-cyan-400/50' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 11a3 3 0 100-6 3 3 0 000 6z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 22s8-7.582 8-14a8 8 0 10-16 0c0 6.418 8 14 8 14z" />
        </svg>
        Near You
    </a>

    <!-- In You -->
    <a href="{{ route('alerts.index', ['mode' => 'in']) }}"
       class="px-6 py-3 rounded-lg font-semibold flex items-center gap-2 shadow-sm transition duration-300
              {{ $mode === 'in' 
                    ? 'bg-slate-700 text-white border-2 border-cyan-400 shadow-lg shadow-cyan-500/20' 
                    : 'bg-slate-800/50 border border-slate-600 text-slate-300 hover:bg-slate-700/50 hover:border-cyan-400/50' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-400" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 11a3 3 0 100-6 3 3 0 000 6z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 22s8-7.582 8-14a8 8 0 10-16 0c0 6.418 8 14 8 14z" />
        </svg>
        In You
    </a>
</div>







       <form method="GET"
      class="mb-8 bg-slate-800/40 border border-slate-600/30 p-6 rounded-xl shadow-lg space-y-4">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <input type="hidden" name="mode" value="{{ $mode }}">


        <!-- Search -->
        <div>
            <label class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35M16.65 10.5a6.15 6.15 0 11-12.3 0 6.15 6.15 0 0112.3 0z"/>
                </svg>
                Search
            </label>
         <input type="text" name="q" value="{{ request('q') }}"
             placeholder="Enter keywords..."
                   class="mt-1 w-full rounded-lg border border-slate-600 bg-slate-900/50 
                          text-slate-200 placeholder-slate-500 
                          focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-150">
        </div>

        <!-- Severity -->
        <div>
            <label class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M4.93 19h14.14a2 2 0 001.74-3l-7.07-12a2 2 0 00-3.48 0l-7.07 12A2 2 0 004.93 19z"/>
                </svg>
                Severity
            </label>
            <select name="severity"
                    class="mt-1 w-full rounded-lg border border-slate-600 bg-slate-900/50 
                           text-slate-200 focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-150">
                <option value="">All</option>
                <option value="low" {{ request('severity')=='low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('severity')=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('severity')=='high' ? 'selected' : '' }}>High</option>
                <option value="critical" {{ request('severity')=='critical' ? 'selected' : '' }}>Critical</option>
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 15a4 4 0 010-8 5 5 0 019.58-1.19A4.5 4.5 0 0119.5 12H20a4 4 0 010 8h-7"/>
                </svg>
                Alert type
            </label>
            <select name="type"
                    class="mt-1 w-full rounded-lg border border-slate-600 bg-slate-900/50 
                           text-slate-200 focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-150">
                <option value="">All</option>
                <option value="storm" {{ request('type')=='storm' ? 'selected' : '' }}>Storm</option>
                <option value="flood" {{ request('type')=='flood' ? 'selected' : '' }}>Flood</option>
                <option value="fire" {{ request('type')=='fire' ? 'selected' : '' }}>Wildfire</option>
                <option value="earthquake" {{ request('type')=='earthquake' ? 'selected' : '' }}>Earthquake</option>
                <option value="other" {{ request('type')=='other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <!-- Date -->
        <div>
            <label class="text-sm font-semibold text-slate-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-400" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                From date
            </label>
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                   class="mt-1 w-full rounded-lg border border-slate-600 bg-slate-900/50 
                          text-slate-200 focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-150">
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-3 pt-4 border-t border-slate-600/30">
        <button type="submit"
                class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-500 text-white font-medium rounded-lg shadow-md 
                       hover:shadow-lg transition-all duration-150 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 4h18M5 8h14M8 12h8m-3 4h2m-6 4h10"/>
            </svg>
            Filter
        </button>

        <a href="{{ route('alerts.index') }}"
           class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-200 font-medium rounded-lg shadow-sm 
                  transition-all duration-150 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Clear filters
        </a>
    </div>
</form>





            <!-- ALERT LIST -->
            <div class="bg-slate-800/40 border border-slate-600/30 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-slate-200 mb-4">
                    Alert List
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="alert-list">

                @foreach ($alertsPaginated as $alert)
                    <div class="rounded-xl shadow-lg p-4 flex flex-col hover:shadow-xl hover:scale-[1.02]
                        transition-all duration-300 border-l-4 bg-slate-800/40
                        {{ match($alert->severity) {
                            'low' => 'border-cyan-400 hover:border-cyan-300',
                            'medium' => 'border-yellow-400/60 hover:border-yellow-400',
                            'high' => 'border-orange-400/60 hover:border-orange-400',
                            'critical' => 'border-red-500/80 hover:border-red-400',
                            default => 'border-slate-500 hover:border-slate-400'
                        } }}"
                    >
                        <!-- IMAGE -->
                        <div class="w-full h-40 rounded-lg overflow-hidden mb-4 bg-slate-900/50 border border-slate-700">
                            @if ($alert->image_path != 'base.png')
                                <img src="{{ asset('storage/' . $alert->image_path) }}"
                                     class="object-contain w-full h-full" />
                            @else
                                <img src="{{ asset('images/base.png') }}"
                                     class="object-contain w-full h-full opacity-60" />
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1 flex flex-col">

                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-slate-100 leading-tight">
                                    {{ $alert->title }}
                                </h3>

                                <span class="px-2 py-1 text-xs rounded-md font-bold uppercase
                                    {{ match($alert->severity) {
                                        'low' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
                                        'medium' => 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30',
                                        'high' => 'bg-orange-500/20 text-orange-300 border border-orange-500/30',
                                        'critical' => 'bg-red-500/20 text-red-300 border border-red-500/30',
                                        default => 'bg-slate-700 text-slate-300'
                                    } }}"
                                >
                                    {{ $alert->severity }}
                                </span>
                            </div>

                            <p class="text-slate-400 text-sm mb-1">
                                {{ ucfirst($alert->type) }} • {{ $alert->created_at->format('d/m/Y H:i') }}
                            </p>

                            <p class="text-slate-300 text-sm line-clamp-3 leading-relaxed">
                                {{ $alert->description }}
                            </p>

                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('alerts.show', $alert->id) }}"
                               class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                View
                            </a>
                        </div>
                    </div>


                @endforeach

                {{-- Pagination links --}}
                <div class="mt-6 col-span-full">
                    {{ $alertsPaginated->links() }}
                </div>

                <!-- NEW ALERT TEMPLATE -->
                <template id="alert-template">
                    <div class="rounded-xl shadow-lg p-4 flex flex-col hover:shadow-xl transition-all duration-300
                                border-l-4 animate-pulse bg-slate-800/40">

                        <!-- IMAGE -->
                        <div class="w-full h-40 rounded-lg overflow-hidden mb-4 bg-slate-900/50 border border-slate-700">
                            <img src="/images/base.png"
                                 alt="default"
                                 class="object-contain w-full h-full opacity-70">
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1 flex flex-col">

                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-slate-100 leading-tight alert-title"></h3>

                                <span class="px-2 py-1 text-xs rounded-md font-bold uppercase alert-severity">
                                </span>
                            </div>

                            <p class="text-slate-400 text-sm alert-meta"></p>

                            <p class="text-slate-300 text-sm line-clamp-3 leading-relaxed mt-2 alert-description"></p>
                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="#" class="alert-view-link inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                View
                            </a>
                        </div>

                    </div>
                </template>

            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>

    <script>
        const socket = io("http://localhost:6001");

        socket.on("connect", () => {
            console.log("✅ Đã kết nối realtime server:", socket.id);
        });

        socket.on("alertCreated", (alert) => {
            console.log("📢 Có alert mới:", alert);
            addAlert(alert);

            if (typeof window.addAlertToMap === "function") {
                window.addAlertToMap(alert);
            } else {
                console.warn("⚠️ Hàm addAlertToMap chưa sẵn sàng");
            }
        });

        function addAlert(alert) {
            const grid = document.getElementById("alert-list");
            const template = document.getElementById("alert-template").content.cloneNode(true);

            const card = template.querySelector("div");

                // IMAGE
                const img = card.querySelector("img");
                img.src = alert.image_path ? `/storage/${alert.image_path}` : "/images/base.png";
                img.alt = alert.title || "alert image";

                // CARD COLOR
                const severityStyles = {
                    low: "border-cyan-400",
                    medium: "border-yellow-400/60",
                    high: "border-orange-400/60",
                    critical: "border-red-500/80",
                };
                card.classList.add(...(severityStyles[alert.severity] || "border-slate-500").split(" "));

                // TITLE
                card.querySelector(".alert-title").textContent = alert.title;

                // BADGE
                const severityBadge = card.querySelector(".alert-severity");
                severityBadge.textContent = alert.severity;

                const badgeStyles = {
                    low: "bg-cyan-500/20 text-cyan-300 border border-cyan-500/30",
                    medium: "bg-yellow-500/20 text-yellow-300 border border-yellow-500/30",
                    high: "bg-orange-500/20 text-orange-300 border border-orange-500/30",
                    critical: "bg-red-500/20 text-red-300 border border-red-500/30",
                };
                severityBadge.classList.add(
                    ...(badgeStyles[alert.severity] || "bg-slate-700 text-slate-300").split(" ")
                );

                // META
                card.querySelector(".alert-meta").textContent =
                    `${capitalize(alert.type)} • ${new Date(alert.created_at).toLocaleString()}`;

                // DESCRIPTION
                card.querySelector(".alert-description").textContent =
                    alert.description || "Không có mô tả.";

                // VIEW LINK
                const viewLink = card.querySelector(".alert-view-link");
                viewLink.href = `/alerts/${alert.id}`;

                // EFFECT
                card.classList.add("alert-new", "animate-pulse");
                setTimeout(() => {
                    card.classList.remove("alert-new", "animate-pulse");
                }, 20000);

                // PREPEND
                grid.prepend(card);
            }

        function capitalize(str) {
            return str ? str.charAt(0).toUpperCase() + str.slice(1) : "";
        }
    </script>
    @endpush

</x-app-layout>
