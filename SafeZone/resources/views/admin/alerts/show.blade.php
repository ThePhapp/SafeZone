@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Alert Detail') }}
    </h2>
@endsection

@section('content')
<div class="max-w-5xl mx-auto py-8 text-gray-200">

    <!-- Thông tin Alert -->
    <div class="bg-gray-900 rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-2xl font-bold mb-4 text-pink-400">{{ $alert->title }}</h3>

        <!-- Ảnh -->
        <div class="mb-6 flex justify-center">
            <img
                src="{{ asset('storage/' . $alert->image_path) }}"
                alt="{{ $alert->title }}"
                class="rounded-lg shadow-md max-h-72 object-contain">
        </div>

        <!-- Thông tin cơ bản -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p><span class="font-semibold text-gray-400">Type:</span>
                    <span class="ml-2">{{ match($alert->type) {
                        1 => 'Flood',
                        2 => 'Storm',
                        3 => 'Earthquake',
                        4 => 'Fire',
                        default => 'Other'
                    } }}</span>
                </p>

                <p><span class="font-semibold text-gray-400">Severity:</span>
                    <span class="ml-2">{{ match($alert->severity) {
                        1 => 'Low',
                        2 => 'Medium',
                        3 => 'High',
                        4 => 'Critical',
                        default => 'Unknown'
                    } }}</span>
                </p>

                <p><span class="font-semibold text-gray-400">Created By:</span>
                    <span class="ml-2">{{ $alert->created_by }}</span>
                </p>

                <p><span class="font-semibold text-gray-400">Created At:</span>
                    <span class="ml-2">{{ \Carbon\Carbon::parse($alert->created_at)->format('d/m/Y H:i') }}</span>
                </p>
            </div>

            <div>
                <p class="font-semibold text-gray-400">Description:</p>
                <p class="bg-gray-800 rounded p-3 mt-1 text-gray-300">
                    {{ $alert->description }}
                </p>
            </div>
        </div>
    </div>

    <!-- Thông tin địa chỉ -->
    <div class="bg-gray-900 rounded-xl shadow-lg p-6 mb-8">
        <h4 class="text-lg font-semibold text-pink-400 mb-3">📍 Address Information</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <p><span class="font-semibold text-gray-400">Address Line:</span> {{ $alert->address->address_line ?? '—' }}</p>
            <p><span class="font-semibold text-gray-400">District:</span> {{ $alert->address->district ?? '—' }}</p>
            <p><span class="font-semibold text-gray-400">City:</span> {{ $alert->address->city ?? '—' }}</p>
            <p><span class="font-semibold text-gray-400">Province:</span> {{ $alert->address->province ?? '—' }}</p>
            <p><span class="font-semibold text-gray-400">Country:</span> {{ $alert->address->country ?? '—' }}</p>
            <p><span class="font-semibold text-gray-400">Postal Code:</span> {{ $alert->address->postal_code ?? '—' }}</p>
        </div>

        <p class="mt-3 text-gray-400 text-sm">
            <span class="font-semibold">Formatted Address:</span>
            {{ $alert->address->formatted_address ?? '—' }}
        </p>
    </div>

    <div class="bg-gray-900 rounded-xl shadow-lg p-6">
        <h4 class="text-lg font-semibold text-pink-400 mb-3">🗺 Location on Map</h4>
        <div class="h-[500px] mb-6">
            {{-- <x-map-alert :alerts="[$alert->resolve()]" :zoom="12"/> --}}
        </div>
    </div>

</div>



@endsection
