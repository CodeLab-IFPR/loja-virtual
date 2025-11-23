{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<section class="w-full p-6 !bg-[#F6F6F6] k rounded-2xl shadow-none">
    <header class="text-center mb-6">
        <h2 class="text-2xl font-normal text-gray-800 uppercase" style="font-family: 'Average Sans', sans-serif;">
            {{ __('Atualizar Senha') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600" style="font-family: 'Alexandria', sans-serif; text-transform: uppercase;">
            {{ __('Garanta que sua conta use uma senha longa e aleatória para maior segurança.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-key h-5 w-5 text-black"></i>
            </div>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block w-full pl-10 py-3 !bg-[#F6F6F6] border border-black rounded-md placeholder-black focus:border-black focus:ring-black text-base"
                autocomplete="current-password" placeholder="{{ __('Senha Atual') }}" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="mt-2 text-sm text-red-600" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-key h-5 w-5 text-black"></i>
            </div>
            <x-text-input id="update_password_password" name="password" type="password"
                class="block w-full pl-10 py-3 !bg-[#F6F6F6] border border-black rounded-md placeholder-black focus:border-black focus:ring-black text-base"
                autocomplete="new-password" placeholder="{{ __('Nova Senha') }}" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-key h-5 w-5 text-black"></i>
            </div>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block w-full pl-10 py-3 !bg-[#F6F6F6] border border-black rounded-md placeholder-black focus:border-black focus:ring-black text-base"
                autocomplete="new-password" placeholder="{{ __('Confirmar Senha') }}" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex justify-center pt-4">
            <button type="submit"
                class="w-full sm:w-1/2 py-3 px-4 text-base font-bold rounded-md shadow-md shadow-black/30 bg-green-600 hover:bg-green-700 text-white transition-all duration-200">
                {{ __('Salvar') }}
            </button>
        </div>

        @if (session('status') === 'password-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-green-600 text-center font-medium mt-3">
            {{ __('Salvo.') }}
        </p>
        @endif
    </form>
</section>