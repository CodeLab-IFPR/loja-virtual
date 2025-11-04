<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Contato - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- IMask.js para máscaras -->
    <script src="https://unpkg.com/imask"></script>

    <style>
        .bg-shalom-beige {
            background-color: #d4cfc4;
        }
        .text-shalom-brown {
            color: #8b7355;
        }
        .btn-enviar {
            background-color: #2d4a2b;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-enviar:hover:not(:disabled) {
            background-color: #1f3320;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-enviar:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .input-field {
            background-color: #e8e5dd;
            border: 1px solid #c4bfb3;
            border-radius: 8px;
            padding: 12px 16px;
            width: 100%;
            font-size: 14px;
            color: #4a4a4a;
            transition: all 0.3s ease;
        }
        .input-field::placeholder {
            color: #8b8b8b;
        }
        .input-field:focus {
            outline: none;
            border-color: #8b7355;
            background-color: #f0ede6;
        }
        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }
        .spinner {
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-shalom-beige">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full">
            <!-- Título -->
            <h1 class="text-4xl font-bold text-center text-shalom-brown mb-8 tracking-wide">
                CONTATO
            </h1>

            <!-- Formulário com Alpine.js -->
            <div x-data="contatoForm()" class="space-y-4">
                <form @submit.prevent="submitForm" class="space-y-4">
                    
                    <!-- Nome Completo -->
                    <div>
                        <input 
                            type="text" 
                            x-model="formData.nome_completo"
                            class="input-field"
                            :class="{ 'border-red-500': errors.nome_completo }"
                            placeholder="Nome Completo"
                            maxlength="255"
                        >
                        <p x-show="errors.nome_completo" x-text="errors.nome_completo" class="error-message"></p>
                    </div>

                    <!-- CNPJ -->
                    <div>
                        <input 
                            type="text" 
                            x-ref="cnpjInput"
                            x-model="formData.cnpj"
                            class="input-field"
                            :class="{ 'border-red-500': errors.cnpj }"
                            placeholder="CNPJ"
                            maxlength="18"
                        >
                        <p x-show="errors.cnpj" x-text="errors.cnpj" class="error-message"></p>
                    </div>

                    <!-- E-mail -->
                    <div>
                        <input 
                            type="email" 
                            x-model="formData.email"
                            class="input-field"
                            :class="{ 'border-red-500': errors.email }"
                            placeholder="E-mail"
                            maxlength="255"
                        >
                        <p x-show="errors.email" x-text="errors.email" class="error-message"></p>
                    </div>

                    <!-- DDD e Telefone -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <input 
                                type="text" 
                                x-ref="dddInput"
                                x-model="formData.ddd"
                                class="input-field"
                                :class="{ 'border-red-500': errors.ddd }"
                                placeholder="DDD"
                                maxlength="2"
                            >
                            <p x-show="errors.ddd" x-text="errors.ddd" class="error-message"></p>
                        </div>
                        <div class="col-span-2">
                            <input 
                                type="text" 
                                x-ref="telefoneInput"
                                x-model="formData.telefone"
                                class="input-field"
                                :class="{ 'border-red-500': errors.telefone }"
                                placeholder="Telefone"
                                maxlength="14"
                            >
                            <p x-show="errors.telefone" x-text="errors.telefone" class="error-message"></p>
                        </div>
                    </div>

                    <!-- Mensagem -->
                    <div>
                        <textarea 
                            x-model="formData.mensagem"
                            class="input-field resize-none"
                            :class="{ 'border-red-500': errors.mensagem }"
                            placeholder="Mensagem"
                            rows="5"
                            maxlength="5000"
                        ></textarea>
                        <p x-show="errors.mensagem" x-text="errors.mensagem" class="error-message"></p>
                    </div>

                    <!-- Botão Enviar -->
                    <button 
                        type="submit"
                        :disabled="loading"
                        class="btn-enviar w-full py-3 px-6 rounded-lg font-semibold text-base flex items-center justify-center gap-2"
                    >
                        <span x-show="loading" class="spinner"></span>
                        <span x-text="loading ? 'Enviando...' : 'Enviar'"></span>
                    </button>
                </form>

                <!-- Modal de Sucesso -->
                <div 
                    x-show="showSuccessModal" 
                    x-cloak
                    @click.away="showSuccessModal = false"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                    style="display: none;"
                >
                    <div 
                        @click.stop
                        class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                    >
                        <div class="text-center">
                            <!-- Ícone de Sucesso -->
                            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                                <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                Mensagem Enviada!
                            </h3>
                            
                            <p class="text-gray-600 mb-6">
                                Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.
                            </p>
                            
                            <button 
                                @click="closeSuccessModal()"
                                class="btn-enviar w-full py-2 px-4 rounded-lg font-semibold"
                            >
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function contatoForm() {
            return {
                formData: {
                    nome_completo: '',
                    cnpj: '',
                    email: '',
                    ddd: '',
                    telefone: '',
                    mensagem: ''
                },
                errors: {},
                loading: false,
                showSuccessModal: false,
                cnpjMask: null,
                telefoneMask: null,

                init() {
                    // Máscara para CNPJ: xx.xxx.xxx/xxxx-xx
                    this.cnpjMask = IMask(this.$refs.cnpjInput, {
                        mask: '00.000.000/0000-00'
                    });

                    // Máscara para Telefone: xxxxx-xxxx ou xxxx-xxxx
                    this.telefoneMask = IMask(this.$refs.telefoneInput, {
                        mask: [
                            { mask: '0000-0000' },
                            { mask: '00000-0000' }
                        ]
                    });

                    // Máscara para DDD: apenas 2 dígitos
                    IMask(this.$refs.dddInput, {
                        mask: '00'
                    });
                },

                // Validação de CNPJ com algoritmo de dígito verificador
                validarCNPJ(cnpj) {
                    cnpj = cnpj.replace(/[^\d]/g, '');
                    
                    if (cnpj.length !== 14) return false;
                    
                    // Elimina CNPJs invalidos conhecidos
                    if (/^(\d)\1+$/.test(cnpj)) return false;
                    
                    let tamanho = cnpj.length - 2;
                    let numeros = cnpj.substring(0, tamanho);
                    let digitos = cnpj.substring(tamanho);
                    let soma = 0;
                    let pos = tamanho - 7;
                    
                    for (let i = tamanho; i >= 1; i--) {
                        soma += numeros.charAt(tamanho - i) * pos--;
                        if (pos < 2) pos = 9;
                    }
                    
                    let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                    if (resultado != digitos.charAt(0)) return false;
                    
                    tamanho = tamanho + 1;
                    numeros = cnpj.substring(0, tamanho);
                    soma = 0;
                    pos = tamanho - 7;
                    
                    for (let i = tamanho; i >= 1; i--) {
                        soma += numeros.charAt(tamanho - i) * pos--;
                        if (pos < 2) pos = 9;
                    }
                    
                    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                    if (resultado != digitos.charAt(1)) return false;
                    
                    return true;
                },

                // Validação do formulário
                validate() {
                    this.errors = {};
                    let isValid = true;

                    // Nome Completo
                    if (!this.formData.nome_completo.trim()) {
                        this.errors.nome_completo = 'O nome completo é obrigatório.';
                        isValid = false;
                    } else if (this.formData.nome_completo.trim().length < 3) {
                        this.errors.nome_completo = 'O nome completo deve ter pelo menos 3 caracteres.';
                        isValid = false;
                    }

                    // CNPJ (opcional, mas se preenchido deve ser válido)
                    if (this.formData.cnpj.trim()) {
                        if (!this.validarCNPJ(this.formData.cnpj)) {
                            this.errors.cnpj = 'CNPJ inválido.';
                            isValid = false;
                        }
                    }

                    // E-mail
                    if (!this.formData.email.trim()) {
                        this.errors.email = 'O e-mail é obrigatório.';
                        isValid = false;
                    } else {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(this.formData.email)) {
                            this.errors.email = 'E-mail inválido.';
                            isValid = false;
                        }
                    }

                    // DDD
                    if (this.formData.ddd.trim() && this.formData.ddd.length !== 2) {
                        this.errors.ddd = 'DDD deve ter 2 dígitos.';
                        isValid = false;
                    }

                    // Telefone
                    if (this.formData.telefone.trim()) {
                        const telefoneNumeros = this.formData.telefone.replace(/\D/g, '');
                        if (telefoneNumeros.length < 8 || telefoneNumeros.length > 9) {
                            this.errors.telefone = 'Telefone inválido.';
                            isValid = false;
                        }
                    }

                    // Mensagem
                    if (!this.formData.mensagem.trim()) {
                        this.errors.mensagem = 'A mensagem é obrigatória.';
                        isValid = false;
                    } else if (this.formData.mensagem.trim().length < 10) {
                        this.errors.mensagem = 'A mensagem deve ter pelo menos 10 caracteres.';
                        isValid = false;
                    }

                    return isValid;
                },

                // Submissão do formulário
                async submitForm() {
                    if (!this.validate()) {
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch('{{ route("contato.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            this.showSuccessModal = true;
                            this.resetForm();
                        } else {
                            // Tratar erros de validação do backend
                            if (data.errors) {
                                this.errors = data.errors;
                            } else {
                                alert(data.message || 'Erro ao enviar mensagem. Tente novamente.');
                            }
                        }
                    } catch (error) {
                        console.error('Erro:', error);
                        alert('Erro ao enviar mensagem. Por favor, tente novamente.');
                    } finally {
                        this.loading = false;
                    }
                },

                // Resetar formulário
                resetForm() {
                    this.formData = {
                        nome_completo: '',
                        cnpj: '',
                        email: '',
                        ddd: '',
                        telefone: '',
                        mensagem: ''
                    };
                    this.errors = {};
                    
                    // Resetar máscaras
                    if (this.cnpjMask) this.cnpjMask.value = '';
                    if (this.telefoneMask) this.telefoneMask.value = '';
                },

                // Fechar modal de sucesso
                closeSuccessModal() {
                    this.showSuccessModal = false;
                }
            }
        }
    </script>
</body>
</html>