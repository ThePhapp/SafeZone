<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('Manage Addresses') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <!-- Main Map -->
        <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-4 mb-6">
            <div class="h-[450px] rounded-lg overflow-hidden">
                <x-map-view :locations="$addresses" :zoom="7" markerType="address"/>
            </div>
        </div>

        <!-- Add Address Button -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('addresses.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-semibold rounded-lg shadow-lg transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Address
            </a>
        </div>

        <!-- Address List -->
        <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-slate-100 mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Your Addresses
            </h3>

            @if ($addresses->isEmpty())
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-slate-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-slate-400 text-lg">
                        No addresses found. Add one to get started!
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($addresses as $address)
                        <div class="bg-slate-900/50 border border-slate-700 rounded-xl shadow-lg p-4 flex flex-col justify-between hover:shadow-xl hover:border-cyan-500/30 transition-all duration-300">
                            
                            <!-- Mini map -->
                            <div id="map-{{ $address->id }}" class="h-40 rounded-lg mb-3 overflow-hidden border border-slate-700"></div>

                            <!-- Address Info -->
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-slate-100 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $address->address_line }}
                                </h4>
                                <p class="text-slate-300 text-sm leading-relaxed">
                                    {{ $address->district }}, {{ $address->city }}<br>
                                    {{ $address->province }}, {{ $address->country }}
                                </p>

                                @if ($address->postal_code)
                                    <p class="text-slate-400 text-xs mt-2 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Postal: {{ $address->postal_code }}
                                    </p>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex justify-between items-center pt-3 border-t border-slate-700">
                                <a href="javascript:void(0)"
                                   onclick="openMapModal({{ $address->toJson() }})"
                                   class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>

                                <form action="{{ route('addresses.destroy', $address->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this address?');">
                                    @csrf
                                    @method('DELETE')
                                
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-400 hover:text-red-300 text-sm font-medium transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

    <!-- Modal - Address Details -->
    <div id="viewMapModal"
         class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-slate-800 border border-slate-600 rounded-xl shadow-2xl w-full max-w-3xl p-6 relative">
            
            <button id="closeModalBtn"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-xl font-semibold text-slate-100 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Address Details
            </h3>

            <div id="addressInfo" class="bg-slate-900/50 border border-slate-700 rounded-lg p-4 mb-4 text-slate-300 text-sm"></div>
            
            <div id="map" class="w-full h-80 rounded-lg overflow-hidden border border-slate-700"></div>
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
