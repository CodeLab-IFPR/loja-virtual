<nav x-data="{ open: false }" class="bg-[#062035] text-white font-sans">
    <!-- Container Principal -->
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Seção Superior do Cabeçalho -->
        <div class="flex items-center justify-between h-24">
            <!-- Logotipo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" title="Página Inicial">
                    <img class="h-12 w-auto" src="{{ asset('images/icons/shalom_header-maior-removebg-preview.png') }}" alt="Logotipo Shalom Vasos Decor">
                </a>

                <!-- Navigation Links (hidden on small screens) -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex ms-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold hover:text-gray-300 {{ request()->routeIs('home') ? 'underline' : '' }}">
                        {{ __('Início') }}
                    </a>
                    <a href="{{ route('catalog') }}" class="text-sm font-semibold hover:text-gray-300 {{ request()->routeIs('catalog*') ? 'underline' : '' }}">
                        {{ __('Catálogo') }}
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold hover:text-gray-300 {{ request()->routeIs('admin.*') ? 'underline' : '' }}">
                                {{ __('Administração') }}
                            </a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold hover:text-gray-300 {{ request()->routeIs('profile.edit') ? 'underline' : '' }}">
                                {{ __('Minha Conta') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Contato WhatsApp (visível em telas médias e maiores) -->
            <div class="hidden md:flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.886-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.371-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01s-.521.074-.792.372c-.272.296-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.626.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <a href="https://wa.me/5544999999999" target="_blank" class="font-semibold" title="Contato via WhatsApp">(44) 9 9999-9999</a>
            </div>

            <!-- Barra de Pesquisa (visível em telas grandes) -->
            <div class="hidden lg:flex flex-1 mx-6 max-w-lg">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input class="w-full bg-gray-200 text-gray-900 rounded-lg py-2.5 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500" type="search" placeholder="Pesquisar…">
                </div>
            </div>

            <!-- Endereço (visível em telas extra grandes) -->
            <div class="hidden xl:flex items-center text-center text-sm">
                <span>Av. José Felipe, 811<br>Nova Esperança</span>
            </div>

            <!-- Minha Conta / Login -->
            <div class="hidden sm:flex items-center ml-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-gray-300" title="Acessar minha conta">
                        <div class="p-2 bg-gray-600 rounded-full">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                            <span class="block text-xs text-gray-400">MINHA CONTA</span>
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-3 hover:text-gray-300" title="Entrar na minha conta">
                        <div class="p-2 bg-gray-600 rounded-full">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="text-sm">
                            <span>Minha Conta</span>
                            <span class="block text-xs text-gray-400 font-semibold">ENTRAR</span>
                        </div>
                    </a>
                @endauth
            </div>

            <!-- Botão Hamburger (visível em telas pequenas) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Botões de Navegação (visível em telas médias e maiores) -->
        <div class="hidden sm:flex justify-center items-center h-16 space-x-10">
            <a href="#" class="bg-white text-gray-900 px-5 py-2.5 rounded-md text-sm font-bold shadow-md hover:bg-gray-200 transition">TODOS OS PRODUTOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">REDONDOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">QUADRADOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">FLORICULTURA</a>
        </div>
    </div>

    <!-- Menu Responsivo (visível em telas pequenas quando aberto) -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-2">
            <!-- Pesquisa no menu responsivo -->
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input class="w-full bg-gray-200 text-gray-900 rounded-lg py-2.5 pl-10 pr-4 focus:outline-none" type="search" placeholder="Pesquisar…">
            </div>

            <!-- Minha Conta / Login no menu responsivo -->
            @auth
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700" title="Acessar minha conta">
                    <div class="p-2 bg-gray-600 rounded-full">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="text-sm">
                        <span class="font-semibold">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                        <span class="block text-xs text-gray-400">MINHA CONTA</span>
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center space-x-3 px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700" title="Entrar na minha conta">
                    <div class="p-2 bg-gray-600 rounded-full">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="text-sm">
                        <span class="font-semibold">Minha Conta</span>
                        <span class="block text-xs text-gray-400">ENTRAR</span>
                    </div>
                </a>
            @endauth

            <!-- Links de navegação no menu responsivo -->
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium bg-white text-gray-900">INÍCIO</a>
            <a href="{{ route('catalog') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">CATÁLOGO</a>
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">ADMINISTRAÇÃO</a>
                @else
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">MINHA CONTA</a>
                @endif
            @endauth

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium bg-white text-gray-900">TODOS OS PRODUTOS</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">REDONDOS</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">QUADRADOS</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">FLORICULTURA</a>

            <!-- Contato e Endereço no menu responsivo -->
            <div class="border-t border-gray-700 pt-4 mt-4 space-y-2 text-sm text-gray-400">
                <div class="flex items-center space-x-2 px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.886-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.371-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01s-.521.074-.792.372c-.272.296-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.626.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>(44) 9 9999-9999</span>
                </div>
                <div class="px-3">Av. José Felipe, 811, Nova Esperança</div>
            </div>
        </div>
    </div>
</nav>