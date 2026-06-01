{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<div class="w-full p-6 sm:p-8" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-900">Segurança</h3>
        <p class="text-sm text-gray-500 mt-0.5">Atualize sua senha de acesso</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Senha Atual -->
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Senha Atual <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="update_password_current_password" name="current_password"
                    :type="'password'"
                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    autocomplete="current-password" placeholder="Sua senha atual"
                    x-bind:type="showCurrent ? 'text' : 'password'" />
                <button type="button" @click="showCurrent = !showCurrent"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <i :class="showCurrent ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Nova Senha -->
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                Nova Senha <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-key text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="update_password_password" name="password"
                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    autocomplete="new-password" placeholder="••••••••"
                    x-bind:type="showNew ? 'text' : 'password'" />
                <button type="button" @click="showNew = !showNew"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <i :class="showNew ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <p class="mt-1.5 text-xs text-gray-400">Mín. 8 caracteres, incluindo número, maiúscula e símbolo.</p>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Confirmar Nova Senha -->
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                Confirmar Nova Senha <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-key text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation"
                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    autocomplete="new-password" placeholder="••••••••"
                    x-bind:type="showConfirm ? 'text' : 'password'" />
                <button type="button" @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                    <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full sm:w-auto px-8 py-2.5 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition">
                Atualizar Senha
            </button>

            @if (session('status') === 'password-updated')
            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="ml-3 text-sm text-green-600 font-medium inline-flex items-center gap-1">
                <i class="fas fa-check-circle"></i> Senha atualizada!
            </span>
            @endif
        </div>
    </form>
</div>