@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Manage Shelters') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-2xl font-bold text-white">Emergency Shelters</h3>
        <a href="{{ route('admin.shelters.create') }}" class="bg-pink-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-pink-700 transition">
            + Add Shelter
        </a>
    </div>

    <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">#</th>
                    <th class="px-4 py-3 text-left font-medium">Name</th>
                    <th class="px-4 py-3 text-left font-medium">Address</th>
                    <th class="px-4 py-3 text-left font-medium">Capacity</th>
                    <th class="px-4 py-3 text-left font-medium">Type</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($shelters as $shelter)
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-4 py-3 text-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-pink-400 font-semibold">{{ $shelter->name }}</td>
                        <td class="px-4 py-3 text-gray-300 max-w-xs truncate">{{ $shelter->address }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $shelter->capacity }} people</td>
                        <td class="px-4 py-3">
                            @if($shelter->type === 'general')
                                <span class="px-2 py-1 bg-blue-800 text-blue-200 rounded text-xs">General</span>
                            @elseif($shelter->type === 'medical')
                                <span class="px-2 py-1 bg-green-800 text-green-200 rounded text-xs">Medical</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-800 text-yellow-200 rounded text-xs">Temporary</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($shelter->status === 'active')
                                <span class="px-2 py-1 bg-green-800 text-green-200 rounded text-xs">Active</span>
                            @elseif($shelter->status === 'full')
                                <span class="px-2 py-1 bg-orange-800 text-orange-200 rounded text-xs">Full</span>
                            @else
                                <span class="px-2 py-1 bg-red-800 text-red-200 rounded text-xs">Closed</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right flex gap-2 justify-end">
                            <a href="{{ route('admin.shelters.edit', $shelter->id) }}" class="text-green-400 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.shelters.destroy', $shelter->id) }}" onsubmit="return confirm('Delete this shelter?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No shelters found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-800">
            {{ $shelters->links() }}
        </div>
    </div>
</div>
@endsection
