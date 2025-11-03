{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<div class="w-full p-6 !bg-[#D9D9D9] border border-black rounded-2xl shadow-none" x-data="profileForm()">
    <div class="text-center mb-6">
        <h3 class="text-2xl font-normal text-gray-800 uppercase" style="font-family: 'Average Sans', sans-serif;">
            {{ __('INFORMAÇÕES PESSOAIS') }}
        </h3>
        <p class="text-sm text-gray-600 mt-1" style="font-family: 'Alexandria', sans-serif; text-transform: uppercase;">
            {{ __('ATUALIZE SEUS DADOS') }}
        </p>
    </div>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-user h-5 w-5 !text-black"></i>
            </div>
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('name', $user->name)"
                required autofocus autocomplete="name"
                placeholder="{{ __('Nome Completo') }}"
                x-model="form.name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-phone h-5 w-5 !text-black"></i>
            </div>
            <x-text-input
                id="phone"
                name="phone"
                type="tel"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('phone', $user->phone)"
                required autocomplete="tel"
                placeholder="{{ __('Telefone') }}"
                @input="formatPhone"
                x-model="form.phone"
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-id-card h-5 w-5 !text-black"></i>
            </div>
            <x-text-input
                id="document"
                name="document"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('document', $user->document)"
                required placeholder="{{ __('CPF ou CNPJ') }}"
                @input="formatDocument"
                x-model="form.document"
            />
            <x-input-error :messages="$errors->get('document')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope h-5 w-5 !text-black"></i>
            </div>
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black opacity-50 cursor-not-allowed  !text-black"
                :value="old('email', $user->email)"
                disabled placeholder="{{ __('Email') }}"
            />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i class="fas fa-lock !text-black"></i>
            </div>
        </div>
        <p class="text-xs text-gray-600 -mt-3 text-center">{{ __('Email não pode ser alterado.') }}</p>

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-map-marker-alt h-5 w-5 !text-black"></i>
            </div>
            <x-text-input
                id="cep"
                name="cep"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('cep', $user->address['cep'] ?? '')"
                required placeholder="{{ __('CEP') }}"
                @input.debounce="fetchAddress"
                x-model="form.cep"
            />
            <x-input-error :messages="$errors->get('cep')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <x-text-input
                id="street"
                name="street"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('street', $user->address['street'] ?? '')"
                required placeholder="{{ __('Rua') }}"
                x-model="form.street"
            />
            <x-input-error :messages="$errors->get('street')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <x-text-input
                id="number"
                name="number"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('number', $user->address['number'] ?? '')"
                required placeholder="{{ __('Número') }}"
                x-model="form.number"
            />
            <x-input-error :messages="$errors->get('number')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <x-text-input
                id="complement"
                name="complement"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('complement', $user->address['complement'] ?? '')"
                placeholder="{{ __('Complemento (opcional)') }}"
                x-model="form.complement"
            />
        </div>

        <div class="relative">
            <x-text-input
                id="city"
                name="city"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('city', $user->address['city'] ?? '')"
                required placeholder="{{ __('Cidade') }}"
                x-model="form.city"
            />
            <x-input-error :messages="$errors->get('city')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="relative">
            <x-text-input
                id="state"
                name="state"
                type="text"
                class="block w-full pl-10 py-3 !bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black focus:ring-black  !text-black"
                :value="old('state', $user->address['state'] ?? '')"
                required placeholder="{{ __('Estado (UF)') }}"
                x-model="form.state"
            />
            <x-input-error :messages="$errors->get('state')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="flex justify-center pt-4">
            <button
                type="submit"
                class="w-full sm:w-1/2 py-3 px-4  font-bold rounded-2xl shadow-md shadow-black/60 transition-all duration-200 text-center"
                :class="isValid ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-[#C7C5C5] text-gray-900 cursor-not-allowed'"
                :disabled="!isValid"
            >
                {{ __('Salvar Alterações') }}
            </button>
        </div>

        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600 text-center mt-3 font-medium">
                {{ __('Perfil atualizado com sucesso!') }}
            </p>
        @endif
    </form>
</div>

<script>
    function profileForm() {
        return {
            form: {
                name: '{{ old('name', $user->name) }}',
                phone: '{{ old('phone', $user->phone ?? '') }}',
                document: '{{ old('document', $user->document ?? '') }}',
                cep: '{{ old('cep', $user->address['cep'] ?? '') }}',
                street: '{{ old('street', $user->address['street'] ?? '') }}',
                number: '{{ old('number', $user->address['number'] ?? '') }}',
                complement: '{{ old('complement', $user->address['complement'] ?? '') }}',
                city: '{{ old('city', $user->address['city'] ?? '') }}',
                state: '{{ old('state', $user->address['state'] ?? '') }}',
            },
            isValid: false,

            init() {
                this.formatPhone();
                this.formatDocument();
                this.$watch('form', () => this.validate(), { deep: true });
                this.validate();
            },

            formatPhone() {
                let phone = this.form.phone.replace(/\D/g, '').substring(0, 11);
                let formatted = '';
                if (phone.length > 0) formatted = '(' + phone.substring(0, 2);
                if (phone.length > 2) formatted += ') ' + phone.substring(2, 3);
                if (phone.length > 3) formatted += ' ' + phone.substring(3, 7);
                if (phone.length > 7) formatted += '-' + phone.substring(7, 11);
                this.form.phone = formatted;
            },

            formatDocument() {
                let digits = this.form.document.replace(/\D/g, '').substring(0, 14);
                let formatted = '';

                if (digits.length <= 11) {
                    // CPF: 000.000.000-00
                    if (digits.length > 0) formatted = digits.substring(0, Math.min(3, digits.length));
                    if (digits.length > 3) formatted += '.' + digits.substring(3, Math.min(6, digits.length));
                    if (digits.length > 6) formatted += '.' + digits.substring(6, Math.min(9, digits.length));
                    if (digits.length > 9) formatted += '-' + digits.substring(9, Math.min(11, digits.length));
                } else {
                    // CNPJ: 00.000.000/0000-00
                    if (digits.length > 0) formatted = digits.substring(0, Math.min(2, digits.length));
                    if (digits.length > 2) formatted += '.' + digits.substring(2, Math.min(5, digits.length));
                    if (digits.length > 5) formatted += '.' + digits.substring(5, Math.min(8, digits.length));
                    if (digits.length > 8) formatted += '/' + digits.substring(8, Math.min(12, digits.length));
                    if (digits.length > 12) formatted += '-' + digits.substring(12, Math.min(14, digits.length));
                }

                this.form.document = formatted;
            },

            validate() {
                const required = ['name', 'phone', 'document', 'cep', 'street', 'number', 'city', 'state'];
                this.isValid = required.every(field => this.form[field]?.trim().length > 0);
            },

            async fetchAddress() {
                const cep = this.form.cep.replace(/\D/g, '');
                if (cep.length !== 8) return;

                try {
                    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                    const data = await response.json();
                    if (!data.erro) {
                        this.form.street = data.logradouro || '';
                        this.form.city = data.localidade || '';
                        this.form.state = data.uf || '';
                    }
                } catch (error) {
                    console.error('Erro ao buscar CEP:', error);
                }
            }
        };
    }
</script>