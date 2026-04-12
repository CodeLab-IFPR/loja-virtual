{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<div class="w-full p-6 sm:p-8" x-data="profileForm()">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-900">Informações da Conta</h3>
        <p class="text-sm text-gray-500 mt-0.5">Mantenha seus dados atualizados</p>
    </div>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Seção: Empresa -->
        <div class="pb-1">
            <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider mb-3">Dados da Empresa</p>
        </div>

        <!-- Nome / Razão Social -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nome / Razão Social <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-building text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="name" name="name" type="text"
                    class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    :value="old('name', $user->name)" required autofocus autocomplete="organization"
                    placeholder="Razão Social" x-model="form.name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
            </div>
        </div>

        <!-- Nome Fantasia -->
        <div>
            <label for="trading_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nome Fantasia</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-store text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="trading_name" name="trading_name" type="text"
                    class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    :value="old('trading_name', $user->trading_name)" autocomplete="off"
                    placeholder="Nome Fantasia (opcional)" />
            </div>
        </div>

        <!-- Responsável + Cidade -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1.5">Responsável / Contato <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400 text-sm"></i>
                    </div>
                    <x-text-input id="contact_name" name="contact_name" type="text"
                        class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                        :value="old('contact_name', $user->contact_name)" required autocomplete="name"
                        placeholder="Nome do responsável" />
                    <x-input-error :messages="$errors->get('contact_name')" class="mt-1 text-sm text-red-600" />
                </div>
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">Cidade <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                    </div>
                    <x-text-input id="city" name="city" type="text"
                        class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                        :value="old('city', $user->address['city'] ?? '')" required
                        placeholder="Cidade" x-model="form.city" />
                    <x-input-error :messages="$errors->get('city')" class="mt-1 text-sm text-red-600" />
                </div>
            </div>
        </div>

        <!-- Seção: Contato -->
        <div class="pb-1 pt-2">
            <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider mb-1">Informações de Contato</p>
            <div class="h-px bg-gray-200"></div>
        </div>

        <!-- Telefone + CPF/CNPJ -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Telefone <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400 text-sm"></i>
                    </div>
                    <x-text-input id="phone" name="phone" type="tel"
                        class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                        :value="old('phone', $user->phone)" required autocomplete="tel"
                        placeholder="(00) 0 0000-0000" @input="formatPhone" x-model="form.phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1 text-sm text-red-600" />
                </div>
            </div>
            <div>
                <label for="document" class="block text-sm font-medium text-gray-700 mb-1.5">CPF / CNPJ <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400 text-sm"></i>
                    </div>
                    <x-text-input id="document" name="document" type="text"
                        class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                        :value="old('document', $user->document)" required
                        placeholder="CPF ou CNPJ" @input="formatDocument" x-model="form.document" />
                    <x-input-error :messages="$errors->get('document')" class="mt-1 text-sm text-red-600" />
                </div>
            </div>
        </div>

        <!-- Email (read-only) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                </div>
                <input type="email"
                    class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-400 cursor-not-allowed"
                    value="{{ $user->email }}" disabled />
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-300 text-sm"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1">O e-mail não pode ser alterado.</p>
        </div>

        <!-- Seção: Endereço -->
        <div class="pb-1 pt-2">
            <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider mb-1">Endereço</p>
            <div class="h-px bg-gray-200"></div>
        </div>

        <!-- CEP -->
        <div>
            <label for="cep" class="block text-sm font-medium text-gray-700 mb-1.5">CEP <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                </div>
                <x-text-input id="cep" name="cep" type="text"
                    class="block w-full pl-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    :value="old('cep', $user->address['cep'] ?? '')" required
                    placeholder="00000-000" @input.debounce="fetchAddress" x-model="form.cep" />
                <x-input-error :messages="$errors->get('cep')" class="mt-1 text-sm text-red-600" />
            </div>
        </div>

        <!-- Rua + Número -->
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <label for="street" class="block text-sm font-medium text-gray-700 mb-1.5">Rua <span class="text-red-500">*</span></label>
                <x-text-input id="street" name="street" type="text"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    :value="old('street', $user->address['street'] ?? '')" required
                    placeholder="Nome da rua" x-model="form.street" />
                <x-input-error :messages="$errors->get('street')" class="mt-1 text-sm text-red-600" />
            </div>
            <div>
                <label for="number" class="block text-sm font-medium text-gray-700 mb-1.5">Número <span class="text-red-500">*</span></label>
                <x-text-input id="number" name="number" type="text"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                    :value="old('number', $user->address['number'] ?? '')" required
                    placeholder="Nº" x-model="form.number" />
                <x-input-error :messages="$errors->get('number')" class="mt-1 text-sm text-red-600" />
            </div>
        </div>

        <!-- Complemento -->
        <div>
            <label for="complement" class="block text-sm font-medium text-gray-700 mb-1.5">Complemento</label>
            <x-text-input id="complement" name="complement" type="text"
                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40"
                :value="old('complement', $user->address['complement'] ?? '')"
                placeholder="Ap, Sala, Bloco... (opcional)" x-model="form.complement" />
        </div>

        <!-- Estado -->
        <div class="w-32">
            <label for="state" class="block text-sm font-medium text-gray-700 mb-1.5">Estado (UF) <span class="text-red-500">*</span></label>
            <x-text-input id="state" name="state" type="text"
                class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:border-[#062035] focus:ring-[#062035]/40 uppercase"
                :value="old('state', $user->address['state'] ?? '')" required
                placeholder="SP" maxlength="2" x-model="form.state" />
            <x-input-error :messages="$errors->get('state')" class="mt-1 text-sm text-red-600" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full sm:w-auto px-8 py-2.5 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition"
                :class="isValid ? '' : 'opacity-60 cursor-not-allowed'"
                :disabled="!isValid">
                Salvar Alterações
            </button>
        </div>

        @if (session('status') === 'profile-updated')
        <p class="text-sm text-green-600 font-medium flex items-center gap-1.5">
            <i class="fas fa-check-circle"></i> Perfil atualizado com sucesso!
        </p>
        @endif
    </form>
</div>

<script>
function profileForm() {
    return {
        form: {
            name: @js(old('name', $user->name)),
            phone: @js(old('phone', $user->phone ?? '')),
            document: @js(old('document', $user->document ?? '')),
            cep: @js(old('cep', $user->address['cep'] ?? '')),
            street: @js(old('street', $user->address['street'] ?? '')),
            number: @js(old('number', $user->address['number'] ?? '')),
            complement: @js(old('complement', $user->address['complement'] ?? '')),
            city: @js(old('city', $user->address['city'] ?? '')),
            state: @js(old('state', $user->address['state'] ?? '')),
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
            let f = '';
            if (phone.length > 0) f = '(' + phone.substring(0, 2);
            if (phone.length > 2) f += ') ' + phone.substring(2, 3);
            if (phone.length > 3) f += ' ' + phone.substring(3, 7);
            if (phone.length > 7) f += '-' + phone.substring(7, 11);
            this.form.phone = f;
        },

        formatDocument() {
            let d = this.form.document.replace(/\D/g, '').substring(0, 14);
            let f = '';
            if (d.length <= 11) {
                if (d.length > 0) f = d.substring(0, Math.min(3, d.length));
                if (d.length > 3) f += '.' + d.substring(3, Math.min(6, d.length));
                if (d.length > 6) f += '.' + d.substring(6, Math.min(9, d.length));
                if (d.length > 9) f += '-' + d.substring(9, Math.min(11, d.length));
            } else {
                if (d.length > 0) f = d.substring(0, Math.min(2, d.length));
                if (d.length > 2) f += '.' + d.substring(2, Math.min(5, d.length));
                if (d.length > 5) f += '.' + d.substring(5, Math.min(8, d.length));
                if (d.length > 8) f += '/' + d.substring(8, Math.min(12, d.length));
                if (d.length > 12) f += '-' + d.substring(12, Math.min(14, d.length));
            }
            this.form.document = f;
        },

        validate() {
            const required = ['name', 'phone', 'document', 'cep', 'street', 'number', 'city', 'state'];
            this.isValid = required.every(field => this.form[field]?.trim().length > 0);
        },

        async fetchAddress() {
            const cep = this.form.cep.replace(/\D/g, '');
            if (cep.length !== 8) return;
            try {
                const r = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await r.json();
                if (!data.erro) {
                    this.form.street = data.logradouro || '';
                    this.form.city   = data.localidade || '';
                    this.form.state  = data.uf || '';
                }
            } catch (e) { console.error(e); }
        }
    };
}
</script>
