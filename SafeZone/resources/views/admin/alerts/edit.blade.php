@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Edit Alert') }}
    </h2>
@endsection

@section('content')
<x-alert/>
<div class="max-w-3xl mx-auto py-8">

    <!-- MAP -->
    <div class="mb-4">
        <label class="block text-gray-300 font-semibold mb-2">Chọn vị trí (Map)</label>
        <x-map :latitude="$alert->address->latitude ?? null" :longitude="$alert->address->longitude ?? null" />
        <div id="map-selected-preview" class="mt-2 text-sm text-gray-300">
            {{ $alert->address->formatted_address ?? 'Chưa có địa chỉ được chọn' }}
        </div>
    </div>

    <div class="bg-gray-900 rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.alerts.update', $alert->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Address -->
            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Address</label>
                <div class="flex gap-2 items-center">
                    <input
                        type="text"
                        id="address_display"
                        required
                        class="flex-1 px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded focus:outline-none"
                        value="{{ old('formatted_address', $alert->address->formatted_address ?? '') }}"
                        placeholder="Chưa có địa chỉ"
                        readonly
                    />
                    <button
                        type="button"
                        id="use-address-btn"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition text-sm">
                        Dùng
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Ấn "Dùng" để lấy địa chỉ đang chọn trên map vào form.</p>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="address_line" id="address_line" value="{{ old('address_line', $alert->address->address_line ?? '') }}">
            <input type="hidden" name="district" id="district" value="{{ old('district', $alert->address->district ?? '') }}">
            <input type="hidden" name="city" id="city" value="{{ old('city', $alert->address->city ?? '') }}">
            <input type="hidden" name="province" id="province" value="{{ old('province', $alert->address->province ?? '') }}">
            <input type="hidden" name="country" id="country" value="{{ old('country', $alert->address->country ?? '') }}">
            <input type="hidden" name="postal_code" id="postal_code" value="{{ old('postal_code', $alert->address->postal_code ?? '') }}">
            <input type="hidden" name="google_place_id" id="google_place_id" value="{{ old('google_place_id', $alert->address->google_place_id ?? '') }}">
            <input type="hidden" name="formatted_address" id="formatted_address" value="{{ old('formatted_address', $alert->address->formatted_address ?? '') }}">
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $alert->address->latitude ?? '') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $alert->address->longitude ?? '') }}">

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $alert->title) }}"
                    required
                    class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-white mb-2">Ảnh</label>
                <input type="file" name="image" id="image" accept="image/*">
                <p class="text-gray-400 text-sm mt-2">Ảnh hiện tại:</p>
                <img id="edit-image" src="{{ asset('storage/' . ($alert->image_path ?? 'base.png')) }}" alt="Ảnh" width="150">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-white mb-1">Description</label>
                <textarea name="description" id="description"
                    class="w-full h-[120px] px-4 py-2 border bg-gray-800 text-white rounded-md focus:ring focus:ring-blue-200 focus:outline-none">{{ old('description', $alert->description) }}</textarea>
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Type</label>
                <select name="type" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    <option value="flood" {{ old('type', $alert->type) == 'flood' ? 'selected' : '' }}>Flood</option>
                    <option value="storm" {{ old('type', $alert->type) == 'storm' ? 'selected' : '' }}>Storm</option>
                    <option value="earthquake" {{ old('type', $alert->type) == 'earthquake' ? 'selected' : '' }}>Earthquake</option>
                    <option value="fire" {{ old('type', $alert->type) == 'fire' ? 'selected' : '' }}>Fire</option>
                    <option value="other" {{ old('type', $alert->type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Severity -->
            <div class="mb-4">
                <label class="block text-gray-300 font-semibold mb-2">Severity</label>
                <select name="severity" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
                    <option value="low" {{ old('severity', $alert->severity) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('severity', $alert->severity) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('severity', $alert->severity) == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ old('severity', $alert->severity) == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>

            <!-- Radius -->
            <div class="mb-4 mt-4">
    <label for="radius" class="block text-gray-300 font-semibold mb-2">
        Bán kính cảnh báo (mét)
    </label>
    <input
        type="number"
        name="radius"
        id="radius"
        value="{{ old('radius', $alert->radius ?? 0) }}"
        min="0"
        class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none"
        placeholder="Nhập bán kính, ví dụ 500">
    <p class="text-xs text-gray-400 mt-1">Đơn vị tính: mét (m). Giá trị 0 nghĩa là không giới hạn phạm vi.</p>
</div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.alerts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
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
            if (preview) preview.textContent = data.formatted_address || data.address_line || 'Chưa có địa chỉ rõ ràng';
        });

        document.getElementById('use-address-btn').addEventListener('click', () => {
            const data = window.lastMapLocation;
            if (!data) return alert('Chưa có vị trí nào được chọn trên bản đồ.');

            for (const key in data) {
                const input = document.getElementById(key);
                if (input) input.value = data[key] || '';
            }

            const display = document.getElementById('address_display');
            if (display) display.value = data.formatted_address || data.address_line || '';
        });

        // Ảnh preview
        document.getElementById('image').addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = ev => document.getElementById('edit-image').src = ev.target.result;
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
