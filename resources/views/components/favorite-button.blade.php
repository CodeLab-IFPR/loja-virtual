@props(['product', 'class' => ''])

@auth
    <button 
        type="button"
        onclick="toggleFavorite({{ $product->id }}, this)"
        class="favorite-btn {{ $class }}"
        data-product-id="{{ $product->id }}"
        data-is-favorited="{{ auth()->user()->hasFavorited($product->id) ? 'true' : 'false' }}"
        title="{{ auth()->user()->hasFavorited($product->id) ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}"
    >
        <svg class="w-6 h-6 transition-all duration-200" fill="{{ auth()->user()->hasFavorited($product->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </button>
@else
    <a 
        href="{{ route('login') }}"
        class="favorite-btn {{ $class }}"
        title="Faça login para favoritar"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </a>
@endauth

@once
@push('styles')
<style>
    .favorite-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 9999px;
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s;
        color: #9CA3AF;
        border: none;
        cursor: pointer;
    }
    
    .favorite-btn:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        color: #EF4444;
    }
    
    .favorite-btn[data-is-favorited="true"] {
        color: #EF4444;
    }
    
    .favorite-btn svg {
        width: 1.5rem;
        height: 1.5rem;
        transition: all 0.2s;
    }
    
    .favorite-btn:hover svg {
        transform: scale(1.1);
    }
    
    .favorite-btn[data-is-favorited="true"] svg {
        fill: currentColor;
    }
    
    .favorite-btn[data-is-favorited="false"] svg {
        fill: none;
    }
</style>
@endpush

@push('scripts')
<script>
function toggleFavorite(productId, button) {
    const svg = button.querySelector('svg');
    const isFavorited = button.dataset.isFavorited === 'true';
    
    // Animação otimista
    button.disabled = true;
    svg.style.transform = 'scale(1.25)';
    
    fetch(`/favoritos/${productId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Atualiza o estado do botão
            button.dataset.isFavorited = data.isFavorited ? 'true' : 'false';
            
            // Atualiza o ícone e as cores
            if (data.isFavorited) {
                // Favorito ativado - coração preenchido em vermelho
                svg.setAttribute('fill', 'currentColor');
                svg.style.fill = 'currentColor';
                button.style.color = '#EF4444';
                button.title = 'Remover dos favoritos';
            } else {
                // Favorito desativado - coração vazio em cinza
                svg.setAttribute('fill', 'none');
                svg.style.fill = 'none';
                button.style.color = '#9CA3AF';
                button.title = 'Adicionar aos favoritos';
            }
            
            // Mostra feedback visual
            showToast(data.message, 'success');
            
            // Se estiver na página de favoritos, recarrega após remover
            if (!data.isFavorited && window.location.pathname === '/favoritos') {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showToast('Erro ao processar favorito', 'error');
    })
    .finally(() => {
        button.disabled = false;
        setTimeout(() => {
            svg.style.transform = 'scale(1)';
        }, 200);
    });
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endonce
