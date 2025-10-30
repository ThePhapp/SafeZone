@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Alert Manage') }}
    </h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8">

    <!-- MAP nằm ngoài form để tránh xung đột nút submit -->
    <div class="mb-4">
        <label class="block text-gray-300 font-semibold mb-2">Chọn vị trí (Map)</label>
        <x-map />
        <!-- preview địa chỉ chọn trên map (không nằm trong form) -->
        <div id="map-selected-preview" class="mt-2 text-sm text-gray-300">Chưa có địa chỉ được chọn</div>
    </div>

    <div class="bg-gray-900 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.alerts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Address</label>

                <!-- Input hiển thị địa chỉ chọn từ map -->
                <div class="flex gap-2 items-center">
                    <input
                        type="text"
                        id="address_display"
                        required
                        class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none"
                        placeholder="Chưa có địa chỉ" readonly />

                    <button
                        type="button"
                        id="use-address-btn"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition text-sm">
                        Dùng
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Ấn "Dùng" để lấy địa chỉ đang chọn trên map vào form.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Title</label>
                <input
                    type="text"
                    name="title"
                    required
                    value="{{ old('title') }}"
                    class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
            </div>

            <!-- hidden inputs để submit -->
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

            <!-- rest of form -->
            <div class="mb-4 mt-4">
                <label for="description" class="block text-sm font-medium text-white mb-1">Description</label>
                <textarea
                    name="description"
                    id="description"
                    class="w-full h-[120px] px-4 py-2 border bg-gray-800 text-white rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                    >{{ old('description') }}</textarea>
            </div>

            <!-- Type -->
            <div class="mb-4 mt-4">
                <label for="type" class="block text-gray-300 font-semibold mb-2">Type</label>
                <select id="type" name="type" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    <option value="">-- Select type --</option>
                    <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Flood</option>
                    <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Storm</option>
                    <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>Earthquake</option>
                    <option value="4" {{ old('type') == '4' ? 'selected' : '' }}>Fire</option>
                    <option value="5" {{ old('type') == '5' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Severity -->
            <div class="mb-4">
                <label for="severity" class="block text-gray-300 font-semibold mb-2">Severity</label>
                <select id="severity" name="severity" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    <option value="">-- Select severity --</option>
                    <option value="1" {{ old('severity') == '1' ? 'selected' : '' }}>Low</option>
                    <option value="2" {{ old('severity') == '2' ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ old('severity') == '3' ? 'selected' : '' }}>High</option>
                    <option value="4" {{ old('severity') == '4' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition">
                    Create
                </button>
                <button type="button" data-confirm-cancel data-redirect-url="#" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                    Cancel
                </button>
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
            preview.textContent = data.formatted_address || data.address_line || 'Chưa có địa chỉ rõ ràng';
        }
        console.log('📍 Map event received (stored to window.lastMapLocation):', data);
    });

    // Handler nút "Dùng" trong form
    const useBtn = document.getElementById('use-address-btn');
    useBtn?.addEventListener('click', () => {
        const data = window.lastMapLocation;
        if (!data) {
            alert('Chưa có vị trí nào được chọn trên bản đồ. Vui lòng chọn 1 vị trí trước.');
            return;
        }

        // Gán vào hidden inputs (form)
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

        console.log('Đã copy địa chỉ từ map vào form:', data);
    });
});
</script>

@endsection