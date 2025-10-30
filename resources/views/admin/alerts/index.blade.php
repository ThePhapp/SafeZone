@extends('layouts.admin')

{{-- Page header section with dashboard title --}}
@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Alert Manage') }}
    </h2>
@endsection

{{-- Main dashboard content section --}}
@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6">

        <!-- Bản đồ chính -->
        <div class="h-[500px] mb-6">
            <x-map-alert :alerts="$alerts" :zoom="7"/>
        </div>
</div>
    <div class="max-w-7xl mx-auto py-10 px-2 sm:px-6 bg-gray-900 min-h-screen text-white">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Add Alert -->
        <a href="{{ route('admin.alerts.create') }}" 
           class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 font-semibold">
            Add Alert
        </a>

        <!-- Search Form -->
        <form method="GET" action="" class="flex gap-2">
            <input type="text" name="search" placeholder="Search..." 
                   class="px-4 py-2 border border-gray-600 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Search
            </button>
            <a href="#" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
               Clear
            </a>
        </form>
    </div>

    <div class="bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 sm:px-6 py-3 text-left font-medium">#</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-medium">Title</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-medium">Type</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-medium">Created at</th>
                    <th class="px-3 sm:px-6 py-3 text-left font-medium">Severity</th>
                    <th class="px-3 sm:px-6 py-3 text-right font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($alerts as $index => $alert)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-gray-300">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap font-semibold text-pink-400 max-w-[180px] truncate">
                            {{ $alert->title }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-gray-300 max-w-[120px] truncate">
                            {{ $alert->type }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-gray-400">
                            {{ $alert->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
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
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right flex flex-col sm:flex-row gap-2 justify-end">
                            <a href="#" class="text-blue-400 hover:underline">View</a>
                            <button type="submit" class="text-red-400 hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-3 sm:px-6 py-4 text-center text-gray-500">
                            No alert found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection