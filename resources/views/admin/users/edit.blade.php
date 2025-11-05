@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-100 leading-tight">
        {{ __('Edit User') }}
    </h2>
@endsection

@section('content')
<div class="max-w-xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-gray-900 rounded-xl shadow p-6">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-300 font-semibold mb-2">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-pink-500 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-300 font-semibold mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-300 font-semibold mb-2">Role</label>
                <select id="role" name="role" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Update</button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
