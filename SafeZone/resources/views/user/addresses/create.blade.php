<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>
            {{ __('Create Address') }}
        </h2>
    </x-slot>

    <x-alert />

    <div class="max-w-4xl mx-auto py-8 px-4">
        
        <!-- Map Section -->
        <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6 mb-6">
            <label class="block text-slate-200 font-semibold mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Select Location (Map)
            </label>
            <div class="rounded-lg overflow-hidden border border-slate-700">
                <x-map />
            </div>
            <div id="map-selected-preview" class="mt-3 text-sm text-slate-400 flex items-center gap-2 p-3 bg-slate-900/50 rounded-lg border border-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                No address selected yet
            </div>
        </div>
    
        <!-- Form Section -->
        <div class="bg-slate-800/40 border border-slate-600/30 rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('addresses.store') }}" enctype="multipart/form-data">
                @csrf
    
                <div class="mb-6">
                    <label class="block text-slate-200 font-semibold mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Address
                    </label>
    
                    <div class="flex gap-3 items-center">
                        <input
                            type="text"
                            id="address_display"
                            required
                            class="flex-1 px-4 py-3 bg-slate-900/50 text-slate-200 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 transition-all"
                            placeholder="No address selected" readonly />
    
                        <button
                            type="button"
                            id="use-address-btn"
                            class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Use
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Click "Use" to apply the selected map location to the form.
                    </p>
                </div>
    
                <!-- Hidden inputs -->
                <input type="hidden" name="address_line" id="address_line">
                <input type="hidden" name="district" id="district">
                <input type="hidden" name="city" id="city">
                <input type="hidden" name="province" id="province">
                <input type="hidden" name="country" id="country">
                <input type="hidden" name="postal_code" id="postal_code">
                <input type="hidden" name="google_place_id" id="google_place_id">
                <input type="hidden" name="formatted_address" id="formatted_address">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
    
                <div class="flex gap-3 pt-4 border-t border-slate-700">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-semibold rounded-lg shadow-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        Create
                    </button>
                    <a href="{{ route('addresses.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-slate-700 hover:bg-slate-600 text-slate-200 font-semibold rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    window.addEventListener('map:location-selected', (e) => {
        const data = e.detail || {};
        window.lastMapLocation = data;
        const preview = document.getElementById('map-selected-preview');
        if (preview) {
            preview.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="text-slate-200">${data.formatted_address || data.address_line || 'Location selected'}</span>
            `;
            preview.classList.remove('text-slate-400');
            preview.classList.add('text-slate-200', 'border-cyan-500/30');
        }
        console.log('📍 Map event received (stored to window.lastMapLocation):', data);
    });

    const useBtn = document.getElementById('use-address-btn');
    useBtn?.addEventListener('click', () => {
        const data = window.lastMapLocation;
        if (!data) {
            alert('No location selected on map. Please select a location first.');
            return;
        }

        document.getElementById('address_line').value = data.address_line || '';
        document.getElementById('district').value = data.district || '';
        document.getElementById('city').value = data.city || '';
        document.getElementById('province').value = data.province || '';
        document.getElementById('country').value = data.country || '';
        document.getElementById('postal_code').value = data.postal_code || '';
        document.getElementById('google_place_id').value = data.google_place_id || '';
        document.getElementById('formatted_address').value = data.formatted_address || '';
        document.getElementById('latitude').value = data.latitude || '';
        document.getElementById('longitude').value = data.longitude || '';

        const display = document.getElementById('address_display');
        if (display) display.value = data.formatted_address || data.address_line || '';

        console.log('Address copied from map to form:', data);
    });
});
</script>

</x-app-layout>
