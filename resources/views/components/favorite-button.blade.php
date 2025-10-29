@props(['product', 'class' => ''])

@php
    $isFavorited = auth()->check() ? auth()->user()->hasFavorited($product->id) : false;
@endphp

@auth
    <button 
        type="button"
        onclick="toggleFavorite({{ $product->id }}, this)"
        class="favorite-btn {{ $class }}"
        data-product-id="{{ $product->id }}"
        data-is-favorited="{{ $isFavorited ? 'true' : 'false' }}"
        title="{{ $isFavorited ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}"
        style="color: {{ $isFavorited ? '#EF4444' : '#6B7280' }};"
    >
        <svg class="heart-icon" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
    </button>
@else
    <a 
        href="{{ route('login') }}"
        class="favorite-btn {{ $class }}"
        title="Faça login para favoritar"
        style="color: #6B7280;"
    >
        <svg class="heart-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
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
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        outline: none;
    }
    
    .favorite-btn:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: scale(1.05);
    }
    
    .favorite-btn:active {
        transform: scale(0.95);
    }
    
    .favorite-btn .heart-icon {
        width: 1.5rem;
        height: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .favorite-btn:hover .heart-icon {
        transform: scale(1.1);
    }
    
    /* Estado não favoritado - cinza vazio */
    .favorite-btn[data-is-favorited="false"] {
        color: #6B7280;
    }
    
    .favorite-btn[data-is-favorited="false"] .heart-icon {
        fill: none;
        stroke: currentColor;
    }
    
    /* Estado favoritado - vermelho preenchido */
    .favorite-btn[data-is-favorited="true"] {
        color: #EF4444;
    }
    
    .favorite-btn[data-is-favorited="true"] .heart-icon {
        fill: currentColor;
        stroke: currentColor;
    }
    
    /* Hover - sempre vermelho */
    .favorite-btn:hover {
        color: #EF4444;
    }
</style>
@endpush

@push('scripts')
<script>
function toggleFavorite(productId, button) {
    const svg = button.querySelector('.heart-icon');
    const isFavorited = button.dataset.isFavorited === 'true';
    
    // Desabilita o botão temporariamente
    button.disabled = true;
    
    // Animação de clique
    button.style.transform = 'scale(0.9)';
    setTimeout(() => {
        button.style.transform = 'scale(1)';
    }, 150);
    
    fetch(`/favoritos/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na requisição');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Atualiza o estado do botão
            const newIsFavorited = data.isFavorited;
            button.dataset.isFavorited = newIsFavorited ? 'true' : 'false';
            
            // Atualiza o visual do ícone
            if (newIsFavorited) {
                // FAVORITADO: Coração preenchido VERMELHO
                svg.setAttribute('fill', 'currentColor');
                button.style.color = '#EF4444';
                button.title = 'Remover dos favoritos';
            } else {
                // NÃO FAVORITADO: Coração vazio CINZA
                svg.setAttribute('fill', 'none');
                button.style.color = '#6B7280';
                button.title = 'Adicionar aos favoritos';
            }
            
            // Mostra notificação
            showToast(data.message, 'success');
            
            // Se estiver na página de favoritos e removeu, recarrega
            if (!newIsFavorited && window.location.pathname === '/favoritos') {
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            }
        }
    })
    .catch(error => {
        console.error('Erro ao favoritar:', error);
        showToast('Erro ao processar favorito. Tente novamente.', 'error');
    })
    .finally(() => {
        button.disabled = false;
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
