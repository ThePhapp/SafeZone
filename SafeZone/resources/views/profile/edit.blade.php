<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-950 via-slate-900 to-gray-950 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile Settings') }}
                </h2>
                <p class="mt-2 text-slate-400">{{ __('Manage your account settings and preferences') }}</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Update Password -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account -->
                <div class="bg-gradient-to-br from-slate-800/40 to-slate-900/20 backdrop-blur-xl border border-slate-600/30 rounded-2xl p-8 shadow-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
