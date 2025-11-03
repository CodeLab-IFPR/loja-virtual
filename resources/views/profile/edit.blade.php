{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#D9D9D9] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-[#D9D9D9] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-[#D9D9D9] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-[#D9D9D9] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>