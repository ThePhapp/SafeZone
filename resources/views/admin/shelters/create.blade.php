@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Create Shelter') }}
    </h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <!-- Map & Location Card -->
    <div class="bg-gradient-to-br from-emerald-900 to-emerald-700 rounded-2xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-emerald-300 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            Select Shelter Location
        </h3>
        <div class="flex gap-2 mb-4">
            <button type="button" id="use-current-location" class="bg-emerald-500 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-600 transition text-sm font-semibold">
                Use Current Location
            </button>
            <button type="button" id="select-on-map" class="bg-teal-500 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 transition text-sm font-semibold">
                Select on Map
            </button>
        </div>
        <div class="rounded-xl overflow-hidden border border-emerald-700 shadow-lg mb-2">
            <x-map />
        </div>
        <div id="map-selected-preview" class="mt-2 text-sm text-emerald-200 italic">No location selected</div>
    </div>

    <!-- Shelter Form Card -->
    <div class="bg-gray-900 rounded-2xl shadow-lg p-8">
        <form method="POST" action="{{ route('admin.shelters.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Address -->
            <div class="mb-6">
                <label for="address_display" class="block text-gray-300 font-semibold mb-2">Address</label>
                <div class="flex gap-2 items-center">
                    <input type="text" id="address_display" required class="flex-1 px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="No address selected" readonly />
                    <button type="button" id="use-address-btn" class="bg-teal-500 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 transition text-sm font-semibold">Use</button>
                </div>
            </div>

            <input type="hidden" name="address" id="address">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-300 font-semibold mb-2">Shelter Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-gray-300 font-semibold mb-2">Description</label>
                <textarea name="description" id="description" class="w-full h-[100px] px-4 py-2 border bg-gray-800 text-white rounded-lg focus:ring focus:ring-emerald-200 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <!-- Capacity -->
            <div class="mb-6">
                <label for="capacity" class="block text-gray-300 font-semibold mb-2">Capacity (people)</label>
                <input type="number" name="capacity" id="capacity" required value="{{ old('capacity', 100) }}" min="0" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <!-- Type -->
            <div class="mb-6">
                <label for="type" class="block text-gray-300 font-semibold mb-2">Type</label>
                <select id="type" name="type" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                    <option value="medical" {{ old('type') == 'medical' ? 'selected' : '' }}>Medical</option>
                    <option value="temporary" {{ old('type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                </select>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-gray-300 font-semibold mb-2">Status</label>
                <select id="status" name="status" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="full" {{ old('status') == 'full' ? 'selected' : '' }}>Full</option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Contact Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="contact_phone" class="block text-gray-300 font-semibold mb-2">Contact Phone</label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
                <div>
                    <label for="contact_email" class="block text-gray-300 font-semibold mb-2">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Facilities -->
            <div class="mb-6">
                <label class="block text-gray-300 font-semibold mb-2">Facilities</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 text-gray-300">
                        <input type="checkbox" name="facilities[]" value="water" class="rounded bg-gray-800 border-gray-600">
                        <span>Water Supply</span>
                    </label>
                    <label class="flex items-center gap-2 text-gray-300">
                        <input type="checkbox" name="facilities[]" value="food" class="rounded bg-gray-800 border-gray-600">
                        <span>Food</span>
                    </label>
                    <label class="flex items-center gap-2 text-gray-300">
                        <input type="checkbox" name="facilities[]" value="medical" class="rounded bg-gray-800 border-gray-600">
                        <span>Medical Aid</span>
                    </label>
                    <label class="flex items-center gap-2 text-gray-300">
                        <input type="checkbox" name="facilities[]" value="electricity" class="rounded bg-gray-800 border-gray-600">
                        <span>Electricity</span>
                    </label>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label for="image" class="block text-gray-300 font-semibold mb-2">Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
            </div>

            <!-- Actions -->
            <div class="flex gap-4 mt-8 justify-end">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-emerald-700 transition">
                    Create Shelter
                </button>
                <a href="{{ route('admin.shelters.index') }}" class="bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-800 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let mapSelectedData = null;

        window.addEventListener('map:location-selected', (e) => {
            const data = e.detail || {};
            mapSelectedData = data;
            const preview = document.getElementById('map-selected-preview');
            if (preview) {
                preview.textContent = data.formatted_address || data.address_line || 'Chưa có địa chỉ rõ ràng';
            }
        });

        document.getElementById('use-address-btn')?.addEventListener('click', () => {
            let data = mapSelectedData || window.lastCurrentLocation;
            if (!data) {
                alert('Chưa có vị trí nào được chọn.');
                return;
            }
            document.getElementById('address').value = data.formatted_address || data.address_line || '';
            document.getElementById('latitude').value = data.latitude || '';
            document.getElementById('longitude').value = data.longitude || '';
            document.getElementById('address_display').value = data.formatted_address || data.address_line || '';
        });

        const currentBtn = document.getElementById('use-current-location');
        currentBtn?.addEventListener('click', () => {
            if (!navigator.geolocation) {
                alert('Trình duyệt không hỗ trợ lấy vị trí hiện tại.');
                return;
            }
            currentBtn.disabled = true;
            currentBtn.textContent = 'Đang lấy vị trí...';
            navigator.geolocation.getCurrentPosition(function(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                if (window.leafletMap) {
                    if (window.leafletCurrentMarker) window.leafletMap.removeLayer(window.leafletCurrentMarker);
                    window.leafletCurrentMarker = L.marker([lat, lng]).addTo(window.leafletMap);
                    window.leafletMap.setView([lat, lng], 15);
                }
                fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                    .then(res => res.json())
                    .then(data => {
                        const locationData = {
                            latitude: lat,
                            longitude: lng,
                            formatted_address: data.display_name || '',
                        };
                        window.lastCurrentLocation = locationData;
                        document.getElementById('map-selected-preview').textContent = locationData.formatted_address;
                    })
                    .finally(() => {
                        currentBtn.disabled = false;
                        currentBtn.textContent = 'Use Current Location';
                    });
            });
        });

        document.getElementById('select-on-map')?.addEventListener('click', () => {
            alert('Hãy click lên bản đồ để chọn vị trí.');
            if (window.leafletMap) {
                window.leafletMap.once('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    if (window.leafletCurrentMarker) window.leafletMap.removeLayer(window.leafletCurrentMarker);
                    window.leafletCurrentMarker = L.marker([lat, lng]).addTo(window.leafletMap);
                    window.leafletMap.setView([lat, lng], 15);
                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                        .then(res => res.json())
                        .then(data => {
                            mapSelectedData = {
                                latitude: lat,
                                longitude: lng,
                                formatted_address: data.display_name || '',
                            };
                            document.getElementById('map-selected-preview').textContent = mapSelectedData.formatted_address;
                        });
                });
            }
        });
    });
</script>
@endsection
