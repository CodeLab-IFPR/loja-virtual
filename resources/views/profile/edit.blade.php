{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Cabeçalho -->
            <div class="mb-2">
                <h1 class="text-2xl font-bold text-gray-900">Meu Perfil</h1>
                <p class="text-sm text-gray-500 mt-0.5">Gerencie as informações da sua conta</p>
            </div>

            <!-- Card: Informações -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Card: Senha -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Card: Excluir conta -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>