<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Catálogo de Produtos</title>
    <style>
        @page {
            margin: 90px 30px 60px 30px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            height: 60px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 8px;
        }

        header .title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }

        header .subtitle {
            font-size: 10px;
            color: #6b7280;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }

        .grid {
            width: 100%;
        }

        .card {
            display: inline-block;
            width: 31%;
            margin: 0 1.5% 18px 0;
            vertical-align: top;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px;
        }

        .card .image-wrap {
            width: 100%;
            height: 130px;
            text-align: center;
            background-color: #f9fafb;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .card .image-wrap img {
            max-width: 100%;
            max-height: 130px;
        }

        .card .image-wrap .no-image {
            display: block;
            padding-top: 55px;
            font-size: 9px;
            color: #9ca3af;
        }

        .card .name {
            font-size: 11px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 3px;
        }

        .card .sku {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .card .category {
            display: inline-block;
            font-size: 8px;
            background-color: #eff6ff;
            color: #1d4ed8;
            padding: 2px 6px;
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .card .price {
            font-size: 13px;
            font-weight: bold;
            color: #047857;
            margin-top: 4px;
        }

        .card .status {
            font-size: 8px;
            margin-top: 3px;
        }

        .status.inactive {
            color: #dc2626;
        }

        .status.active {
            color: #059669;
        }

        .empty-state {
            text-align: center;
            padding: 60px 0;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <header>
        <div class="title">Catálogo de Produtos</div>
        <div class="subtitle">
            Gerado em {{ $generatedAt->format('d/m/Y \à\s H:i') }} &middot; {{ $products->count() }} produto(s)
        </div>
    </header>

    <footer>
        Catálogo gerado automaticamente pelo sistema
    </footer>

    <div class="grid">
        @forelse ($products as $product)
            <div class="card">
                <div class="image-wrap">
                    @if ($product->pdf_image)
                        <img src="{{ $product->pdf_image }}" alt="{{ $product->name }}">
                    @else
                        <span class="no-image">Sem imagem</span>
                    @endif
                </div>

                @if ($product->category)
                    <div class="category">{{ $product->category->name }}</div>
                @endif

                <div class="name">{{ $product->name }}</div>
                <div class="sku">SKU: {{ $product->sku }}</div>
                <div class="price">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                <div class="status {{ $product->active ? 'active' : 'inactive' }}">
                    {{ $product->active ? 'Ativo' : 'Inativo' }}
                    &middot;
                    {{ $product->stock > 0 ? 'Em estoque (' . $product->stock . ')' : 'Sem estoque' }}
                </div>
            </div>
        @empty
            <div class="empty-state">Nenhum produto encontrado para os filtros selecionados.</div>
        @endforelse
    </div>
</body>
</html>