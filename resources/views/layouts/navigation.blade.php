<nav x-data="{ open: false }" class="bg-[#062035] text-white font-sans">
    <!-- Container Principal -->
    <div class="mx-auto px-4 py-2 lg:p-[0.5rem_2rem_0.5rem_1rem]">
        <!-- Seção Superior do Cabeçalho -->
        <div class="flex items-center justify-between h-24 gap-4">

            <!-- SEÇÃO ESQUERDA: Logotipo + Links de Navegação -->
            <div class="flex items-center gap-6">
                <!-- Logotipo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" title="Página Inicial">
                        <img class="h-24 w-auto"
                             src="{{ asset('images/icons/shalom_header-maior-removebg-preview.png') }}"
                             alt="Logotipo Shalom Vasos Decor"
                             style="filter: brightness(0) invert(1);">
                    </a>
                </div>
            </div>

            <!-- Links de Navegação -->
            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ route('home') }}"
                   class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('home') ? 'underline' : '' }}">
                    {{ __('Início') }}
                </a>
                <a href="{{ route('catalog') }}"
                   class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('catalog*') ? 'underline' : '' }}">
                    {{ __('Catálogo') }}
                </a>
                <a href="{{route('about')}}"
                   class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('about') ? 'underline' : '' }}">
                    {{ __('Quem Somos') }}
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('admin.*') ? 'underline' : '' }}">
                            {{ __('Administração') }}
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}"
                           class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('profile.edit') ? 'underline' : '' }}">
                            {{ __('Minha Conta') }}
                        </a>
                        <a href="{{ route('favorites.index') }}"
                           class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('favorites.*') ? 'underline' : '' }}">
                            {{ __('Favoritos') }}
                        </a>
                        <a href="{{ route('orders.index') }}"
                           class="text-lg font-semibold hover:text-gray-300 transition {{ request()->routeIs('orders.*') ? 'underline' : '' }}">
                            {{ __('Meus Pedidos') }}
                        </a>
                    @endif
                @endauth
            </div>

            <!-- SEÇÃO CENTRAL: Barra de Pesquisa -->
            <div class="hidden lg:flex flex-1 max-w-xl">
                <form action="{{ route('catalog') }}" method="GET" class="relative w-full" role="search">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        class="w-full bg-gray-200 text-gray-900 rounded-lg py-2.5 pl-10 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        type="text" name="search" placeholder="Pesquisar produtos, categorias, materiais…"
                        value="{{ request('search') }}" autocomplete="off">
                    <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- SEÇÃO DIREITA: WhatsApp + Endereço + Minha Conta -->
            <div class="hidden lg:flex items-center gap-6">

                <!-- Contato WhatsApp -->
                <!-- <div class="flex items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" viewBox="0 0 24 24"
                         fill="currentColor">
                         <path
                             d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z" />
                     </svg>
                     <a href="https://wa.me/5544999999999" target="_blank"
                         class="text-sm font-semibold hover:text-gray-300 transition" title="Contato via WhatsApp">(44) 9
                         9999-9999</a>
                 </div>-->

                <!-- Endereço -->
                <!--   <div class="hidden xl:flex items-center text-sm text-center">
                      <span>Rua Projetada Y, 5<br>Nova Esperança/PR</span>
                  </div> -->

                <!-- Minha Conta -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(!Auth::user()->isAdmin())
                            {{-- Cart icon with badge --}}
                            @php $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity'); @endphp
                            <a href="{{ route('cart.index') }}" class="relative flex items-center text-white hover:text-gray-300 transition" title="Meu Carrinho">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                @if($cartCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center leading-none">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                                @endif
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-gray-300"
                           title="Acessar minha conta">
                            <div class="p-2 bg-gray-600 rounded-full">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="text-sm">
                                <span class="font-semibold">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                                <span class="block text-xs text-gray-400">MINHA CONTA</span>
                            </div>
                        </a>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="flex items-center space-x-3 hover:text-gray-300"
                               title="Entrar na minha conta">
                                <div class="p-2 bg-gray-600 rounded-full">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <span>Minha Conta</span>
                                    <span class="block text-xs text-gray-400 font-semibold">ENTRAR</span>
                                </div>
                            </a>
                            <a href="{{ route('register') }}"
                               class="px-3 py-1.5 rounded-lg border border-white/30 text-sm font-semibold text-white hover:bg-white/10 transition whitespace-nowrap">
                                Criar Conta
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Botão Hamburger -->
            <div class="relative z-10 flex items-center lg:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-4 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
        <!-- Navegação Secundária -->
        <!-- <div class="hidden sm:flex justify-center items-center h-16 space-x-10">
            <a href="#"
                class="bg-white text-gray-900 px-5 py-2.5 rounded-md text-sm font-bold shadow-md hover:bg-gray-200 transition">TODOS
                OS PRODUTOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">REDONDOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">QUADRADOS</a>
            <a href="#" class="hover:text-gray-300 text-sm font-semibold transition">FLORICULTURA</a>
        </div> -->

        <!-- Menu Responsivo -->
        <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-2">
                <form action="{{ route('catalog') }}" method="GET" class="relative w-full" role="search">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input class="w-full bg-gray-200 text-gray-900 rounded-lg py-2.5 pl-10 pr-10 focus:outline-none"
                           type="text" name="search" placeholder="Pesquisar produtos…"
                           value="{{ request('search') }}" autocomplete="off">
                    <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Perfil') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('favorites.index')">{{ __('Meus Favoritos') }}
                    </x-responsive-nav-link>
                    @if(!Auth::user()->isAdmin())
                        <x-responsive-nav-link :href="route('cart.index')">{{ __('Meu Carrinho') }}</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('orders.index')">{{ __('Meus Pedidos') }}</x-responsive-nav-link>
                    @endif
                @endauth

                <a href="{{ route('home') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">INÍCIO</a>
                <a href="{{ route('catalog') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">CATÁLOGO</a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">ADMINISTRAÇÃO</a>
                    @endif
                @endauth

                <!-- <a href="#" class="block px-3 py-2 rounded-md text-base font-medium bg-white text-gray-900">TODOS OS
                    PRODUTOS</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">REDONDOS</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">QUADRADOS</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">FLORICULTURA</a> -->

                <!-- Minha Conta -->
                <div class="border-t border-gray-700 pt-4 mt-2">
                    @auth
                        <div class="flex justify-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-gray-300"
                               title="Acessar minha conta">
                                <div class="p-2 bg-gray-600 rounded-full">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <span class="font-semibold">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                                    <span class="block text-xs text-gray-400">MINHA CONTA</span>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center gap-2 p-3 rounded-md hover:bg-gray-700 transition"
                               title="Entrar na minha conta">
                                <div class="p-2 bg-gray-600 rounded-full">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="text-sm text-center">
                                    <span class="block font-semibold">Minha Conta</span>
                                    <span class="block text-xs text-gray-400 font-semibold">ENTRAR</span>
                                </div>
                            </a>
                            <a href="{{ route('register') }}"
                               class="flex items-center justify-center p-3 rounded-md text-base font-medium text-white border border-white/30 hover:bg-white/10 transition text-center">
                                Criar Conta
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
</nav>
