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
            {{ __('Cảnh báo thiên tai') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="max-w-7xl mx-auto py-10 sm:px-6">
        <!-- MAP -->
        <div class="h-[500px] mb-6">
            <x-map-alert :alerts="$alerts" :zoom="7" :user-addresses="$userAddresses" />
        </div>

        <div class="max-w-7xl mx-auto py-10 sm:px-6">
    <!-- 🔹 Nút lọc cấp cao -->
    <div class="flex justify-center mb-6 gap-3">
        <a href="{{ route('alerts.index', ['mode' => 'all']) }}"
           class="px-5 py-2.5 rounded-xl font-medium flex items-center gap-2
                  {{ $mode === 'all' ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }}
                  hover:scale-[1.03] transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M3 12h18M3 20h18"/>
            </svg>
            Tất cả cảnh báo
        </a>

        <a href="{{ route('alerts.index', ['mode' => 'near']) }}"
           class="px-5 py-2.5 rounded-xl font-medium flex items-center gap-2
                  {{ $mode === 'near' ? 'bg-green-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }}
                  hover:scale-[1.03] transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 22s8-7.582 8-14a8 8 0 10-16 0c0 6.418 8 14 8 14z"/>
            </svg>
            Cảnh báo gần bạn
        </a>
    </div>


       <form method="GET"
      class="mb-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-6 rounded-2xl shadow-lg space-y-4">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Search -->
        <div>
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <!-- Search Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35M16.65 10.5a6.15 6.15 0 11-12.3 0 6.15 6.15 0 0112.3 0z"/>
                </svg>
                Tìm kiếm
            </label>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Nhập từ khóa..."
                   class="mt-1 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 
                          text-gray-900 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150">
        </div>

        <!-- Severity -->
        <div>
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <!-- Alert Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M4.93 19h14.14a2 2 0 001.74-3l-7.07-12a2 2 0 00-3.48 0l-7.07 12A2 2 0 004.93 19z"/>
                </svg>
                Độ nghiêm trọng
            </label>
            <select name="severity"
                    class="mt-1 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 
                           text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-150">
                <option value="">Tất cả</option>
                <option value="low" {{ request('severity')=='low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ request('severity')=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ request('severity')=='high' ? 'selected' : '' }}>High</option>
                <option value="critical" {{ request('severity')=='critical' ? 'selected' : '' }}>Critical</option>
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <!-- Cloud/Storm Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 15a4 4 0 010-8 5 5 0 019.58-1.19A4.5 4.5 0 0119.5 12H20a4 4 0 010 8h-7"/>
                </svg>
                Loại cảnh báo
            </label>
            <select name="type"
                    class="mt-1 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 
                           text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-green-400 focus:border-green-400 transition-all duration-150">
                <option value="">Tất cả</option>
                <option value="storm" {{ request('type')=='storm' ? 'selected' : '' }}>Bão</option>
                <option value="flood" {{ request('type')=='flood' ? 'selected' : '' }}>Lũ lụt</option>
                <option value="fire" {{ request('type')=='fire' ? 'selected' : '' }}>Cháy rừng</option>
            </select>
        </div>

        <!-- Date -->
        <div>
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2">
                <!-- Calendar Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Từ ngày
            </label>
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                   class="mt-1 w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 
                          text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150">
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
        <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-medium rounded-xl shadow-md 
                       hover:shadow-lg hover:from-blue-700 transition-all duration-150 flex items-center gap-2">
            <!-- Filter Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 4h18M5 8h14M8 12h8m-3 4h2m-6 4h10"/>
            </svg>
            Lọc
        </button>

        <a href="{{ route('alerts.index') }}"
           class="px-5 py-2.5 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium rounded-xl shadow-sm 
                  hover:bg-gray-400 dark:hover:bg-gray-600 transition-all duration-150 flex items-center gap-2">
            <!-- X Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Xóa lọc
        </a>
    </div>
</form>





        <!-- ALERT LIST -->
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Alert List
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="alert-list">

                @foreach ($alerts as $alert)
                    <div class="rounded-xl shadow-lg p-4 flex flex-col hover:shadow-xl hover:scale-[1.02]
                        transition-all duration-300 border-l-4
                        {{ match($alert->severity) {
                            'low' => 'border-green-400 bg-green-900/20',
                            'medium' => 'border-yellow-400 bg-yellow-900/20',
                            'high' => 'border-orange-400 bg-orange-900/20',
                            'critical' => 'border-red-500 bg-red-900/30',
                            default => 'border-gray-400 bg-gray-700/30'
                        } }}"
                    >
                        <!-- ẢNH -->
                        <div class="w-full h-40 rounded-lg overflow-hidden mb-4 bg-gray-700 border border-gray-600">
                            @if ($alert->image_path != 'base.png')
                                <img src="{{ asset('storage/' . $alert->image_path) }}"
                                     class="object-contain w-full h-full" />
                            @else
                                <img src="{{ asset('images/base.png') }}"
                                     class="object-contain w-full h-full opacity-60" />
                            @endif
                        </div>

                        <!-- NỘI DUNG -->
                        <div class="flex-1 flex flex-col">

                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-white leading-tight">
                                    {{ $alert->title }}
                                </h3>

                                <span class="px-2 py-1 text-xs rounded-md font-bold uppercase
                                    {{ match($alert->severity) {
                                        'low' => 'bg-green-700 text-green-100',
                                        'medium' => 'bg-yellow-700 text-yellow-100',
                                        'high' => 'bg-orange-700 text-orange-100',
                                        'critical' => 'bg-red-700 text-red-100',
                                        default => 'bg-gray-700 text-gray-200'
                                    } }}"
                                >
                                    {{ $alert->severity }}
                                </span>
                            </div>

                            <p class="text-gray-300 text-sm mb-1">
                                {{ ucfirst($alert->type) }} • {{ $alert->created_at->format('d/m/Y H:i') }}
                            </p>

                            <p class="text-gray-200 text-sm line-clamp-3 leading-relaxed">
                                {{ $alert->description }}
                            </p>

                        </div>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="#"
                               onclick=""
                               class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
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

                <!-- TEMPLATE ALERT MỚI -->
                <template id="alert-template">
                    <div class="rounded-xl shadow-lg p-4 flex flex-col hover:shadow-xl transition-all duration-300
                                border-l-4 animate-pulse bg-gray-700/30">

                        <!-- IMAGE -->
                        <div class="w-full h-40 rounded-lg overflow-hidden mb-4 bg-gray-700 border border-gray-600">
                            <img src="/images/base.png"
                                 alt="default"
                                 class="object-contain w-full h-full opacity-70">
                        </div>

                        <!-- CONTENT -->
                        <div class="flex-1 flex flex-col">

                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-white leading-tight alert-title"></h3>

                                <span class="px-2 py-1 text-xs rounded-md font-bold uppercase alert-severity">
                                </span>
                            </div>

                            <p class="text-gray-300 text-sm alert-meta"></p>

                            <p class="text-gray-200 text-sm line-clamp-3 leading-relaxed mt-2 alert-description"></p>
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
                    low: "border-green-400 bg-green-900/20",
                    medium: "border-yellow-400 bg-yellow-900/20",
                    high: "border-orange-400 bg-orange-900/20",
                    critical: "border-red-500 bg-red-900/30",
                };
                card.classList.add(...(severityStyles[alert.severity] || "border-gray-400 bg-gray-700/30").split(" "));

                // TITLE
                card.querySelector(".alert-title").textContent = alert.title;

                // BADGE
                const severityBadge = card.querySelector(".alert-severity");
                severityBadge.textContent = alert.severity;

                const badgeStyles = {
                    low: "bg-green-700 text-green-100",
                    medium: "bg-yellow-700 text-yellow-100",
                    high: "bg-orange-700 text-orange-100",
                    critical: "bg-red-700 text-red-100",
                };
                severityBadge.classList.add(
                    ...(badgeStyles[alert.severity] || "bg-gray-700 text-gray-200").split(" ")
                );

                // META
                card.querySelector(".alert-meta").textContent =
                    `${capitalize(alert.type)} • ${new Date(alert.created_at).toLocaleString()}`;

                // DESCRIPTION
                card.querySelector(".alert-description").textContent =
                    alert.description || "Không có mô tả.";

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
