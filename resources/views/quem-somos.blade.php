@extends('layouts.app')

@section('Title', 'Quem Somos')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Hero compacto -->

        <div class="relative bg-[#062035] overflow-hidden bg-cover bg-center sm:bg-left"
             style="background-image: linear-gradient(rgba(6,32,53,0.7), rgba(6,32,53,0.7)), url('{{ asset('images/slides/VasosModelo.png') }}');">

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 md:py-20 flex flex-col items-center text-center">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3">
                    Vasos de Concreto Artesanais<br class="hidden sm:block"> Direto da Fábrica
                </h1>

                <div class="text-gray-300 text-sm sm:text-base md:text-lg max-w-xl space-y-3 sm:space-y-4 mb-6">
                    <p>A Shalom Vazos Decor nasceu com o propósito de levar beleza, elegância e personalidade para ambientes residenciais e comerciais.</p>
                    <p>Acreditamos que a decoração vai além da estética: ela transmite sensações, acolhe pessoas e transforma espaços em experiências únicas.</p>
                    <p>Trabalhamos constantemente para trazer produtos que acompanhem as tendências do mercado.</p>
                </div>
            </div>
        </div>

        {{-- Título da seção --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12">
            <h2 class="text-2xl md:text-3xl font-bold text-[#062035] text-center">
                Nossa História
            </h2>
        </div>

        {{-- Texto da hist�ria, sem imagem --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-gray-700 text-lg leading-relaxed space-y-4">
            <p>
                Desde 2008, a Shalom Vazos Decor produz vasos de concreto e peças para decoração e jardinagem em Nova Esperança PR. Começamos de forma simples e, ao longo dos anos, fomos aprimorando nossos processos e modelos sempre com atenção especial ao acabamento e à durabilidade de cada peça.
            </p>
            <p>
                Atendemos tanto ambientes residenciais quanto projetos de paisagismo, das demandas menores às de maior escala, sempre buscando unir resistência, funcionalidade e um bom acabamento visual, sem complicação.
            </p>
            <p>
                Mais do que anos de experiência, carregamos o aprendizado de cada cliente e de cada peça produzida no dia a dia e isso está presente em tudo o que sai da nossa fábrica.
            </p>
        </div>

        {{-- T�tulo: Nosso Produto --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <h2 class="text-2xl md:text-3xl font-bold text-[#062035] text-center">
                Nosso Produto
            </h2>
        </div>

        {{-- Imagem destaque--}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            <img
                src="{{ asset('images/slides/SuculentaVaso.jpg') }}"
                alt="Vaso de concreto Shalom Vazos Decor"
                class="w-full max-w-md mx-auto rounded-lg shadow-md mb-8">

            <div class="text-gray-700 text-lg leading-relaxed space-y-4">
                <p>
                    Trabalhamos com matéria-prima selecionada e um processo de cura cuidadoso, que garante peças mais resistentes ao tempo, ao sol e à chuva ideais tanto para uso interno quanto externo. Cada vaso passa por inspeção antes de sair da fábrica, assegurando o padrão de qualidade que nossos clientes já conhecem.
                </p>
                <p>
                    Também trabalhamos com encomendas personalizadas, adaptando tamanhos, formatos e acabamentos conforme a necessidade de cada projeto, seja para um jardim residencial, uma área comercial ou um paisagismo de maior porte.
                </p>
                <p>
                    Se você procura vasos de concreto com qualidade, durabilidade e um acabamento que valoriza qualquer ambiente, a Shalom Vazos Decor está pronta para atender você direto da fábrica, com preço justo e atenção em cada detalhe.
                </p>
            </div>
        </div>

        {{-- Diferenciais --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-2xl md:text-3xl font-bold text-[#062035] text-center mb-10">
                Por que escolher a Shalom Vazos Decor
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white rounded-xl border border-gray-100 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Produção Artesanal</h3>
                    <p class="text-sm text-gray-500">Cada peça é feita com cuidado, do início ao acabamento final.</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5L21 7.5V17a2 2 0 01-2 2H3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Material Resistente</h3>
                    <p class="text-sm text-gray-500">Concreto de qualidade, durável para uso interno e externo.</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Atendimento Direto</h3>
                    <p class="text-sm text-gray-500">Fale direto com a fábrica, sem intermediários no processo.</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Encomendas Sob Medida</h3>
                    <p class="text-sm text-gray-500">Tamanhos e acabamentos personalizados para o seu projeto.</p>
                </div>

            </div>
        </div>

        {{-- CTA Final --}}
        <div class="bg-[#062035] text-white py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                @guest
                    <h2 class="text-2xl md:text-3xl font-bold mb-3">Quer ver preços e fazer pedidos?</h2>
                    <p class="text-gray-300 mb-6">Cadastre-se para ter acesso completo ao nosso catálogo</p>
                    <a href="{{ route('register') }}"
                       class="inline-block bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                        Cadastrar-se Agora
                    </a>
                @else
                    <h2 class="text-2xl md:text-3xl font-bold mb-3">Explore todo o catálogo</h2>
                    <p class="text-gray-300 mb-6">Veja todos os produtos disponíveis na nossa loja</p>
                    <a href="{{ route('catalog') }}"
                       class="inline-block bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                        Explorar Catálogo
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
