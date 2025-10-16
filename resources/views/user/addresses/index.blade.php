<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Addresses') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <!-- Bản đồ chính -->
        <div class="h-[500px] mb-6">
            <x-map-view :locations="$addresses" :zoom="7" />
        </div>

        <!-- Nút thêm địa chỉ -->
        <div class="flex justify-end mb-8">
            <a href="{{ route('addresses.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Address
            </a>
        </div>

        <!-- Danh sách địa chỉ -->
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Your Addresses
            </h3>

            @if ($addresses->isEmpty())
                <p class="text-gray-500 dark:text-gray-400 text-center py-10">
                    No addresses found. Add one to get started!
                </p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($addresses as $address)
                        <div
                            class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow p-4 flex flex-col justify-between hover:shadow-lg transition">
                            
                            <!-- Mini map -->
                            <div id="map-{{ $address->id }}" class="h-40 rounded-lg mb-3 overflow-hidden"></div>

                            <!-- Thông tin địa chỉ -->
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $address->address_line }}
                                </h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    {{ $address->district }}, {{ $address->city }}<br>
                                    {{ $address->province }}, {{ $address->country }}
                                </p>

                                @if ($address->postal_code)
                                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                        Postal Code: {{ $address->postal_code }}
                                    </p>
                                @endif
                            </div>

                            <!-- Hành động -->
                            <div class="mt-4 flex justify-between items-center">
                                <a href="javascript:void(0)"
                                   onclick="openMapModal({{ $address->toJson() }})"
                                   class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    View
                                </a>

                                

                                <form action="{{ route('addresses.destroy', $address->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this address?');">
                                    @csrf
                                    @method('DELETE')
                                
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-600 dark:text-red-400 hover:underline text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal hiển thị bản đồ chi tiết -->
    <div id="viewMapModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-[90%] md:w-[70%] lg:w-[50%] p-6 relative">
            
            <button id="closeModalBtn"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                ✕
            </button>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                Address Details
            </h3>
            <div id="addressInfo" class="text-gray-700 dark:text-gray-300 mb-4 text-sm"></div>
            <div id="map" class="w-full h-64 rounded-lg overflow-hidden"></div>
        </div>
    </div>

    <!-- Mini Map Script -->
    <script>
        const addresses = @json($addresses);

        addresses.forEach(address => {
            if (address.latitude && address.longitude) {
                const map = new maplibregl.Map({
                    container: `map-${address.id}`,
                    style: `https://api.maptiler.com/maps/streets/style.json?key=${window.MAPTILER_KEY}`,
                    center: [address.longitude, address.latitude],
                    zoom: 13,
                    interactive: false
                });

                new maplibregl.Marker({ color: '#e63946' })
                    .setLngLat([address.longitude, address.latitude])
                    .addTo(map);
            }
        });

        function openMapModal(address) {
            const modal = document.getElementById('viewMapModal');
            const info = document.getElementById('addressInfo');
            const mapContainer = document.querySelector('#viewMapModal #map');

            info.innerHTML = `
                <p><strong>Address:</strong> ${address.formatted_address || address.address_line}</p>
                <p><strong>Latitude:</strong> ${address.latitude}</p>
                <p><strong>Longitude:</strong> ${address.longitude}</p>
            `;

            modal.classList.remove('hidden');

            if (window.viewMapInstance) {
                window.viewMapInstance.remove();
            }

            if (address.latitude && address.longitude) {
                window.viewMapInstance = new maplibregl.Map({
                    container: mapContainer,
                    style: `https://api.maptiler.com/maps/streets/style.json?key=${window.MAPTILER_KEY}`,
                    center: [address.longitude, address.latitude],
                    zoom: 14,
                });

                new maplibregl.Marker({ color: '#e63946' })
                    .setLngLat([address.longitude, address.latitude])
                    .setPopup(new maplibregl.Popup({ offset: 25 })
                        .setHTML(`<strong>${address.formatted_address}</strong>`))
                    .addTo(window.viewMapInstance);
            }
        }

        document.getElementById('closeModalBtn').addEventListener('click', () => {
            document.getElementById('viewMapModal').classList.add('hidden');
        });
    </script>

</x-app-layout>
