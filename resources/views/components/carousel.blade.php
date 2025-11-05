@props([
'slides' => [],
'interval' => 5000
])

@php
// The ID generation should be the only thing in this block
$id = 'carousel_'.\Illuminate\Support\Str::random(3);
@endphp

<div id="{{ $id }}"
    class="relative w-full overflow-hidden h-[400px] sm:h-[450px] md:h-[500px] lg:h-[550px] xl:h-[600px]"
    data-interval="{{ $interval }}" tabindex="0">

    @foreach($slides as $i => $slide)
    <div class="absolute inset-0 transition-opacity duration-700 ease-in-out {{ $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }} carousel-slide"
        data-index="{{ $i }}" aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">

        <div class="w-full h-full  relative">
            @if(!empty($slide['image']))
            <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] ?? 'Slide' }}" class="w-full h-full object-cover">
            @else
            <div
                class="w-full h-full flex items-center justify-center bg-gradient-to-r from-green-600 to-green-800 text-white">
                <div class="text-center px-6">
                    <div class="text-6xl mb-4">🏺</div>
                </div>
            </div>
            @endif

            @php
            // Define a posição do texto (left, center, right)
            $textPosition = $slide['text_position'] ?? 'left';

            // Define o gradiente do overlay baseado na posição
            $overlayGradient = match($textPosition) {
            'right' => 'bg-gradient-to-l via-black/40 to-transparent',
            'center' => 'bg-gradient-to-b from-transparent via-black/50 to-transparent',
            default => 'bg-gradient-to-r via-black/40 to-transparent',
            };

            // Define o alinhamento do container
            $containerAlign = match($textPosition) {
            'right' => 'justify-end',
            'center' => 'justify-center',
            default => 'justify-start',
            };

            // Define o alinhamento do texto
            $textAlign = match($textPosition) {
            'center' => 'text-center',
            'right' => 'text-right',
            default => 'text-left',
            };
            @endphp

            <!-- Overlay escuro -->
            <div class="absolute inset-0 {{ $overlayGradient }}"></div>

            <!-- Conteúdo do Slide -->
            <div class="absolute inset-0 flex items-center {{ $containerAlign }}">
                <div class="w-full h-full flex items-center {{ $containerAlign }}">
                    <!-- Container de conteúdo com posicionamento específico -->
                    <div
                        class="w-full px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 
                                {{ $textPosition === 'right' ? 'text-right flex justify-end' : ($textPosition === 'center' ? 'flex justify-center' : 'text-left flex justify-start') }}">

                        <div
                            class="max-w-xl lg:max-w-2xl 
                                    {{ $textPosition === 'right' ? 'mr-0 lg:mr-8 xl:mr-16' : ($textPosition === 'left' ? 'ml-0 lg:ml-8 xl:ml-16' : 'mx-auto') }} 
                                    text-white space-y-3 sm:space-y-4 md:space-y-5 lg:space-y-6 animate-fade-in {{ $textAlign }}">

                            @if(!empty($slide['subtitle']))
                            <p class="text-xs sm:text-sm md:text-base lg:text-lg font-medium uppercase tracking-wider text-[#062035] animate-slide-up"
                                style="animation-delay: 0.1s;">
                                {{ $slide['subtitle'] }}
                            </p>
                            @endif

                            @if(!empty($slide['title']))
                            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight animate-slide-up text-black"
                                style="animation-delay: 0.2s;">
                                {{ $slide['title'] }}
                            </h1>
                            @endif

                            @if(!empty($slide['description']))
                            <p class="text-sm sm:text-base md:text-lg lg:text-xl max-w-lg animate-slide-up text-gray-800"
                                style="animation-delay: 0.3s;">
                                {{ $slide['description'] }}
                            </p>
                            @endif

                            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 pt-2 sm:pt-4 animate-slide-up {{ $textPosition === 'center' ? 'justify-center' : ($textPosition === 'right' ? 'justify-end' : 'justify-start') }}"
                                style="animation-delay: 0.4s;">
                                @if(!empty($slide['button_text']) && !empty($slide['link']))
                                <a href="{{ $slide['link'] }}"
                                    class="inline-flex items-center justify-center bg-[#062035] hover:bg-[#0a1d3f] text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-semibold text-base sm:text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl whitespace-nowrap">
                                    {{ $slide['button_text'] }}
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                @endif

                                @if(!empty($slide['secondary_button_text']) && !empty($slide['secondary_link']))
                                <a href="{{ $slide['secondary_link'] }}"
                                    class="inline-flex items-center justify-center bg-white/10 hover:bg-white/80 backdrop-blur-sm text-black border-2 border-[#062035] px-6 sm:px-8 py-2.5 sm:py-3 rounded-lg font-semibold text-base sm:text-lg transition-all duration-300 whitespace-nowrap">
                                    {{ $slide['secondary_button_text'] }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Prev / Next -->
    <button type="button"
        class="absolute left-2 sm:left-4 md:left-6 top-1/2 transform -translate-y-1/2 text-black hover:text-gray-700 transition-all duration-200 hover:scale-110 rounded-full w-8 h-12 sm:w-10 sm:h-16 md:w-12 md:h-20 flex items-center justify-center carousel-prev z-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm"
        aria-label="Anterior">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 md:h-10 md:w-10" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <button type="button"
        class="absolute right-2 sm:right-4 md:right-6 top-1/2 transform -translate-y-1/2 text-black hover:text-gray-700 transition-all duration-200 hover:scale-110 rounded-full w-8 h-12 sm:w-10 sm:h-16 md:w-12 md:h-20 flex items-center justify-center carousel-next z-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm"
        aria-label="Próximo">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8 md:h-10 md:w-10" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Dots -->
    <div
        class="absolute bottom-3 sm:bottom-4 md:bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 sm:space-x-2.5 md:space-x-3 z-10">
        @foreach($slides as $i => $slide)
        <button type="button"
            class="w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-3.5 md:h-3.5 rounded-full border-2 bg-transparent transition-all duration-300 carousel-dot hover:scale-125 {{ $i === 0 ? 'border-white bg-white' : 'border-white/60 hover:border-white' }}"
            aria-label="Ir para slide {{ $i+1 }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}"
            data-index="{{ $i }}"></button> @endforeach
    </div>

    <style>
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .animate-slide-up {
        animation: slide-up 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
    }

    /* Reset animations quando o slide fica inativo */
    .carousel-slide.opacity-0 .animate-slide-up,
    .carousel-slide.opacity-0 .animate-fade-in {
        animation: none;
        opacity: 0;
    }

    /* Trigger animations quando o slide fica ativo */
    .carousel-slide.opacity-100 .animate-slide-up,
    .carousel-slide.opacity-100 .animate-fade-in {
        animation-play-state: running;
    }

    /* Responsividade para mobile */
    @media (max-width: 640px) {
        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }

    /* Ajustes para touch devices */
    @media (hover: none) and (pointer: coarse) {

        .carousel-prev,
        .carousel-next {
            opacity: 0.7;
        }

        .carousel-prev:active,
        .carousel-next:active {
            opacity: 1;
            transform: translateY(-50%) scale(0.95);
        }
    }
    </style>

    <script>
    (function() {
        const root = document.getElementById('{{ $id }}');
        if (!root) return;
        const slides = Array.from(root.querySelectorAll('.carousel-slide[data-index]'));
        const prevBtn = root.querySelector('.carousel-prev');
        const nextBtn = root.querySelector('.carousel-next');
        const dots = Array.from(root.querySelectorAll('.carousel-dot[data-index]'));
        let index = 0;
        const interval = Number(root.dataset.interval) || 5000;
        let timer = null;

        function show(i) {
            slides.forEach((el, idx) => {
                const isActive = idx === i;
                el.classList.toggle('opacity-100', isActive);
                el.classList.toggle('opacity-0', !isActive);
                el.classList.toggle('pointer-events-none', !isActive);
                el.setAttribute('aria-hidden', (!isActive).toString());
            });
            dots.forEach((d, idx) => {
                d.classList.toggle('bg-white', idx === i);
                d.classList.toggle('bg-white/50', idx !== i);
                d.setAttribute('aria-current', (idx === i).toString());
            });
            index = i;
        }

        function next() {
            show((index + 1) % slides.length);
        }

        function prev() {
            show((index - 1 + slides.length) % slides.length);
        }

        function start() {
            stop();
            timer = setInterval(next, interval);
        }

        function stop() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        // Hook events
        if (nextBtn) nextBtn.addEventListener('click', () => {
            next();
            start();
        });
        if (prevBtn) prevBtn.addEventListener('click', () => {
            prev();
            start();
        });
        dots.forEach(d => d.addEventListener('click', (e) => {
            const idx = Number(d.getAttribute('data-index'));
            show(idx);
            start();
        }));

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);

        root.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prev();
                start();
            }
            if (e.key === 'ArrowRight') {
                next();
                start();
            }
        });

        root.setAttribute('tabindex', '0');

        if (slides.length > 0) {
            show(0);
            start();
        }
    })();
    </script>
</div>