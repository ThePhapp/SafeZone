@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Statistics & Reports') }}
    </h2>
@endsection

@section('content')
<div class="max-w-5xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-pink-600 to-pink-400 rounded-xl p-6 shadow-lg text-white flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="flex items-center gap-2">
                <span class="inline-block bg-white/20 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20h9" /></svg>
                </span>
                <div class="text-4xl font-bold">{{ $totalAlerts }}</div>
            </div>
            <div class="mt-2 text-base font-semibold tracking-wide">Total Alerts</div>
        </div>
        <div class="bg-gradient-to-br from-indigo-600 to-indigo-400 rounded-xl p-6 shadow-lg text-white flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="flex items-center gap-2">
                <span class="inline-block bg-white/20 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </span>
                <div class="text-4xl font-bold">{{ $alertsByType->count() }}</div>
            </div>
            <div class="mt-2 text-base font-semibold tracking-wide">Alert Types</div>
        </div>
        <div class="bg-gradient-to-br from-green-600 to-green-400 rounded-xl p-6 shadow-lg text-white flex flex-col items-center hover:scale-105 transition-transform duration-200">
            <div class="flex items-center gap-2">
                <span class="inline-block bg-white/20 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                </span>
                <div class="text-4xl font-bold">{{ $alertsBySeverity->sum('count') }}</div>
            </div>
            <div class="mt-2 text-base font-semibold tracking-wide">Severity Records</div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-pink-400 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            Alerts by Type
        </h3>
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">Type</th>
                    <th class="px-3 py-3 text-left font-medium">Count</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($alertsByType as $row)
                    <tr>
                        <td class="px-3 py-2 text-pink-400 font-semibold">{{ $row->type }}</td>
                        <td class="px-3 py-2 text-gray-300">{{ $row->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-green-400 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
            Alerts by Severity
        </h3>
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">Severity</th>
                    <th class="px-3 py-3 text-left font-medium">Count</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($alertsBySeverity as $row)
                    <tr>
                        <td class="px-3 py-2 text-green-400 font-semibold">{{ ucfirst($row->severity) }}</td>
                        <td class="px-3 py-2 text-gray-300">{{ $row->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl shadow-lg p-6 mb-8">
        <h3 class="text-lg font-bold text-indigo-400 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20h9" /></svg>
            Recent Alerts
        </h3>
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">Title</th>
                    <th class="px-3 py-3 text-left font-medium">Type</th>
                    <th class="px-3 py-3 text-left font-medium">Severity</th>
                    <th class="px-3 py-3 text-left font-medium">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($recentAlerts as $alert)
                    <tr>
                        <td class="px-3 py-2 text-pink-400 font-semibold">{{ $alert->title }}</td>
                        <td class="px-3 py-2 text-gray-300">{{ $alert->type }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-1 rounded text-xs"
                                style="background: {{ $alert->severity == 'low' ? '#059669' : ($alert->severity == 'medium' ? '#f59e42' : ($alert->severity == 'high' ? '#ea580c' : '#dc2626')) }}; color: white;">
                                {{ ucfirst($alert->severity) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-400">{{ $alert->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
