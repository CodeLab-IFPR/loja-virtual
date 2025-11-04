@props([
    'slides' => [],
    'interval' => 5000
])

@php
    // The ID generation should be the only thing in this block
    $id = 'carousel_'.\Illuminate\Support\Str::random(3);
@endphp

<div id="{{ $id }}" class="relative w-full overflow-hidden h-64 md:h-96 lg:h-[520px]" data-interval="{{ $interval }}" tabindex="0">

    @foreach($slides as $i => $slide)
        <div class="absolute inset-0 transition-opacity duration-700 ease-in-out {{ $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }} carousel-slide" data-index="{{ $i }}" aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">

            <div class="w-full h-full bg-gray-200 relative">
                @if(!empty($slide['image']))
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] ?? 'Slide' }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-green-600 to-green-800 text-white">
                        <div class="text-center px-6">
                            <div class="text-6xl mb-4">🏺</div>
                        </div>
                    </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/20 to-transparent"></div>

                <div class="absolute inset-y-0 left-0 flex items-center">
                    <div class="max-w-3xl p-6 md:p-12 lg:p-20 text-white">
                        <div class="mt-28">
                            <a href="{{ $slide['link'] ?? route('catalog') }}" class="inline-block bg-black text-white px-24 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Ver Catálogo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Prev / Next -->
    <button type="button" class="absolute left-4 top-1/2 transform -translate-y-1/2  text-black rounded-full w-10 h-20 flex items-center justify-center carousel-prev z-10" aria-label="Anterior">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-30 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </button>

    <button type="button" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-black rounded-full w-10 h-20 flex items-center justify-center carousel-next z-10" aria-label="Próximo">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-30 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
        @foreach($slides as $i => $slide)
            <button type="button" class="w-3 h-3 rounded-full border-2 bg-transparent transition-colors carousel-dot {{ $i === 0 ? 'border-white' : 'border-white/50' }}" aria-label="Ir para slide {{ $i+1 }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" data-index="{{ $i }}"></button>        @endforeach
    </div>

    <script>
        (function(){
            const root = document.getElementById('{{ $id }}');
            if (!root) return;
            const slides = Array.from(root.querySelectorAll('.carousel-slide[data-index]'));
            const prevBtn = root.querySelector('.carousel-prev');
            const nextBtn = root.querySelector('.carousel-next');
            const dots = Array.from(root.querySelectorAll('.carousel-dot[data-index]'));
            let index = 0;
            const interval = Number(root.dataset.interval) || 5000;
            let timer = null;

            function show(i){
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

            function next(){
                show((index + 1) % slides.length);
            }
            function prev(){
                show((index - 1 + slides.length) % slides.length);
            }

            function start(){
                stop();
                timer = setInterval(next, interval);
            }
            function stop(){
                if (timer) { clearInterval(timer); timer = null; }
            }

            // Hook events
            if (nextBtn) nextBtn.addEventListener('click', () => { next(); start(); });
            if (prevBtn) prevBtn.addEventListener('click', () => { prev(); start(); });
            dots.forEach(d => d.addEventListener('click', (e) => { const idx = Number(d.getAttribute('data-index')); show(idx); start(); }));

            root.addEventListener('mouseenter', stop);
            root.addEventListener('mouseleave', start);

            root.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') { prev(); start(); }
                if (e.key === 'ArrowRight') { next(); start(); }
            });

            root.setAttribute('tabindex', '0');

            if (slides.length > 0) {
                show(0);
                start();
            }
        })();
    </script>
</div>
