{{-- resources/views/profile/partials/delete-user-form.blade.php --}}
<section class="w-full p-6 bg-[#F6F6F6]  rounded-2xl shadow-none space-y-6">
    <header class="text-center">
        <h2 class="text-2xl font-normal text-gray-800 uppercase" style="font-family: 'Average Sans', sans-serif;">
            {{ __('Excluir Conta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600" style="font-family: 'Alexandria', sans-serif; text-transform: uppercase;">
            {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos. Antes de excluir sua conta, faça o download de quaisquer dados ou informações que deseje manter.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="py-3 px-6 text-base font-bold rounded-2xl bg-red-600 hover:bg-red-700 text-white shadow-md shadow-black/60 transition-all duration-200">
        {{ __('Excluir Conta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-6 bg-[#F6F6F6] border border-black rounded-2xl shadow-none">
            @csrf
            @method('delete')

            <h2 class="text-xl font-normal text-gray-800 uppercase text-center"
                style="font-family: 'Average Sans', sans-serif;">
                {{ __('Tem certeza de que deseja excluir sua conta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 text-center" style="font-family: 'Alexandria', sans-serif;">
                {{ __('Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente removidos. Por favor, insira sua senha para confirmar que você deseja excluir permanentemente sua conta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Senha') }}" class="sr-only" />

                <div class="relative max-w-xs mx-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-key h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="password" name="password" type="password"
                        class="block w-full pl-10 py-3 bg-[#F6F6F6] border border-black rounded-md  focus:border-black focus:ring-black"
                        placeholder="{{ __('Senha') }}" autocomplete="current-password" />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')"
                    class="mt-2 text-sm text-red-600 text-center" />
            </div>

            <div class="mt-6 flex justify-center gap-4">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="py-2 px-6 text-base font-bold rounded-2xl bg-[#C7C5C5] text-gray-900 shadow-md shadow-black/60">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button type="submit"
                    class="py-2 px-6 text-base font-bold rounded-2xl bg-red-600 hover:bg-red-700 text-white shadow-md shadow-black/60">
                    {{ __('Excluir Conta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>