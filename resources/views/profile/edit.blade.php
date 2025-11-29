{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>


    <div class="py-12 bg-[#F6F6F6] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="bg-[#F6F6F6] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-[#F6F6F6] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-[#F6F6F6] border border-black rounded-2xl p-0 shadow-none">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>