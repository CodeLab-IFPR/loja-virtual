@php
    $files = glob(public_path('images/slides/*'));
    $image = $files ? asset('images/slides/' . basename($files[0])) : null;
@endphp

@extends('layouts.app')

@section('Title', 'Quem Somos')

@section('content')
    <div class="min-h-screen bg-gray-50">

        <!-- Hero compacto -->
        <div class="relative bg-[#062035] overflow-hidden">
            @if(!empty($slides) && $slides[0]['image'])
                <img src="{{ $slides[0]['image'] }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
            @endif
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 flex flex-col items-center text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Vasos de Concreto Artesanais<br class="hidden sm:block"> Direto da Fábrica</h1>

                <p class="text-gray-300 text-lg max-w-xl mb-6">A Shalom Vazos Decor nasceu com o propósito de levar beleza, elegância e personalidade para ambientes residenciais e comerciais.</p>

                <p class="text-gray-300 text-lg max-w-xl mb-6">Acreditamos que a decoração vai além da estética: ela transmite sensações, acolhe pessoas e transforma espaços em experiências únicas.</p>

                <p class="text-gray-300 text-lg max-w-xl mb-6">Trabalhamos constantemente para trazer produtos que acompanhem as tendências do mercado.</p>
                </a>
            </div>
        </div>
    </div>
@endsection
