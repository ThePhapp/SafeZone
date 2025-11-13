
@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-pink-600 to-pink-400 rounded-xl p-6 shadow text-white flex flex-col items-center">
            <div class="text-3xl font-bold">{{ $alertsCount ?? '0' }}</div>
            <div class="mt-2 text-sm">Alerts</div>
            <a href="{{ route('admin.alerts.index') }}" class="mt-4 text-xs underline">Manage Alerts</a>
        </div>
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-400 rounded-xl p-6 shadow text-white flex flex-col items-center">
            <div class="text-3xl font-bold">{{ $usersCount ?? '0' }}</div>
            <div class="mt-2 text-sm">Users</div>
            <a href="{{ route('admin.users.index') }}" class="mt-4 text-xs underline">Manage Users</a>
        </div>
        <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl p-6 shadow text-white flex flex-col items-center">
            <div class="text-3xl font-bold">{{ $activeAlerts ?? '0' }}</div>
            <div class="mt-2 text-sm">Active Alerts</div>
        </div>
        <div class="bg-gradient-to-br from-yellow-600 to-yellow-400 rounded-xl p-6 shadow text-white flex flex-col items-center">
            <div class="text-3xl font-bold">{{ $statisticsCount ?? '0' }}</div>
            <div class="mt-2 text-sm">Statistics</div>
            <a href="{{ route('admin.statistics') }}" class="mt-4 text-xs underline">View Reports</a>
        </div>
    </div>

    <!-- Recent Alerts Table -->
    <div class="bg-gray-900 rounded-xl shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-white mb-4">Recent Alerts</h3>
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">Title</th>
                    <th class="px-3 py-3 text-left font-medium">Type</th>
                    <th class="px-3 py-3 text-left font-medium">Severity</th>
                    <th class="px-3 py-3 text-left font-medium">Created</th>
                    <th class="px-3 py-3 text-right font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($recentAlerts ?? [] as $alert)
                    <tr>
                        <td class="px-3 py-2 text-pink-400 font-semibold">{{ $alert->title }}</td>
                        <td class="px-3 py-2 text-gray-300">{{ $alert->type }}</td>
                        <td class="px-3 py-2">
                            @if($alert->severity === 'low')
                                <span class="px-2 py-1 bg-green-800 text-green-200 rounded text-xs">Low</span>
                            @elseif($alert->severity === 'medium')
                                <span class="px-2 py-1 bg-yellow-800 text-yellow-200 rounded text-xs">Medium</span>
                            @elseif($alert->severity === 'high')
                                <span class="px-2 py-1 bg-orange-800 text-orange-200 rounded text-xs">High</span>
                            @elseif($alert->severity === 'critical')
                                <span class="px-2 py-1 bg-red-800 text-red-200 rounded text-xs">Critical</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-gray-400">{{ $alert->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('admin.alerts.show', $alert->id) }}" class="text-blue-400 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-2 text-center text-gray-500">No recent alerts</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Weather Map Section -->
    <div class="bg-gradient-to-br from-sky-900 to-sky-700 rounded-2xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-sky-300 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 01.88-7.9A5 5 0 0117 7a4.5 4.5 0 01.5 9H5.5A3.5 3.5 0 013 15z" /></svg>
            Global Weather Map
        </h3>
        <div class="rounded-xl overflow-hidden border border-sky-700 shadow-lg">
            <iframe
                width="100%"
                height="500"
                src="https://earth.nullschool.net/"
                frameborder="0"
                style="border:0; min-height:400px; background:#0a2540;"
                allowfullscreen
            ></iframe>
        </div>
    </div>
    <!-- Map Section -->
    <div class="h-[400px]">
        <x-map-view :locations="$locations ?? []" :zoom="7" />
    </div>
</div>
@endsection