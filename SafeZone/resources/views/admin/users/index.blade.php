@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Manage Users') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-gray-900 rounded-xl shadow p-6 mb-8">
        <table class="min-w-full divide-y divide-gray-700 text-sm">
            <thead class="bg-gray-700 text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-3 py-3 text-left font-medium">#</th>
                    <th class="px-3 py-3 text-left font-medium">Name</th>
                    <th class="px-3 py-3 text-left font-medium">Email</th>
                    <th class="px-3 py-3 text-left font-medium">Role</th>
                    <th class="px-3 py-3 text-right font-medium">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($users as $index => $user)
                    <tr>
                        <td class="px-3 py-2 text-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2 text-pink-400 font-semibold">{{ $user->name }}</td>
                        <td class="px-3 py-2 text-gray-300">{{ $user->email }}</td>
                        <td class="px-3 py-2 text-indigo-400">{{ $user->role }}</td>
                        <td class="px-3 py-2 text-right flex gap-2 justify-end">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-green-400 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-2 text-center text-gray-500">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection
