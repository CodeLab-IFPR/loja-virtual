{{-- resources/views/profile/partials/delete-user-form.blade.php --}}
<div class="w-full p-6 sm:p-8">
    <div class="mb-5">
        <h3 class="text-lg font-bold text-gray-900">Excluir Conta</h3>
        <p class="text-sm text-gray-500 mt-0.5">Esta ação é permanente e não pode ser desfeita</p>
    </div>

    <div class="rounded-lg border border-red-200 bg-red-50 p-4 mb-5">
        <div class="flex items-start gap-3">
            <i class="fas fa-triangle-exclamation text-red-500 mt-0.5 shrink-0"></i>
            <p class="text-sm text-red-700">
                Uma vez que sua conta for excluída, todos os seus dados serão permanentemente removidos.
                Antes de excluir, faça o download de qualquer informação que deseje manter.
            </p>
        </div>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        <i class="fas fa-trash-can text-sm"></i>
        Excluir Conta
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="mb-5">
                <h2 class="text-lg font-bold text-gray-900">Confirmar exclusão</h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Esta ação não pode ser desfeita. Todos os seus dados serão removidos permanentemente.
                </p>
            </div>

            <div class="rounded-lg border border-red-200 bg-red-50 p-3 mb-5">
                <p class="text-sm text-red-700 flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation shrink-0"></i>
                    Digite sua senha para confirmar que deseja excluir sua conta.
                </p>
            </div>

            <div x-data="{ showPwd: false }">
                <label for="modal_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Senha <span class="text-red-500">*</span>
                </label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                    </div>
                    <x-text-input id="modal_password" name="password"
                        class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-red-500 focus:ring-red-500/40"
                        autocomplete="current-password" placeholder="Sua senha"
                        x-bind:type="showPwd ? 'text' : 'password'" />
                    <button type="button" @click="showPwd = !showPwd"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                        <i :class="showPwd ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5 text-sm text-red-600" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 text-sm font-semibold rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </x-secondary-button>

                <x-danger-button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash-can text-sm"></i>
                    Confirmar Exclusão
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>