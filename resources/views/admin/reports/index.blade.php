@extends('layouts.admin')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Relatórios de Vendas</h1>

        <!-- Date Filter -->
        <form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">De</label>
                <input type="date" name="date_from" value="{{ $from->toDateString() }}"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Até</label>
                <input type="date" name="date_to" value="{{ $to->toDateString() }}"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                Filtrar
            </button>
            <span class="text-xs text-gray-500 self-center">
                Período: {{ $from->format('d/m/Y') }} – {{ $to->format('d/m/Y') }}
            </span>
        </form>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">Faturamento Total</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                    <p class="text-sm text-gray-500">Pedidos Realizados</p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($avgTicket, 2, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">Ticket Médio</p>
                </div>
            </div>
        </div>

        <!-- Sales Bar Chart -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Vendas por Dia</h3>
            @if(count($dateRange) > 0)
            <div class="relative" style="height: 280px;">
                <canvas id="salesChart"></canvas>
            </div>
            @else
                <p class="text-gray-500 text-sm">Nenhum dado para o período selecionado.</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            <!-- Top 10 Products -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 mb-4">Top 10 Produtos Mais Vendidos</h3>
                @if($topProducts->isEmpty())
                    <p class="text-gray-500 text-sm">Nenhum dado disponível.</p>
                @else
                    <div class="space-y-3">
                        @foreach($topProducts as $i => $product)
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 w-5 text-center">{{ $i + 1 }}</span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $product->product_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">{{ $product->total_qty }} un.</p>
                                <p class="text-xs text-gray-500">R$ {{ number_format($product->total_revenue, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Orders by Status Doughnut -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 mb-4">Pedidos por Status</h3>
                @if($byStatus->isEmpty())
                    <p class="text-gray-500 text-sm">Nenhum dado disponível.</p>
                @else
                    <div class="relative" style="height: 240px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                @endif
            </div>

        </div>

        <!-- Sales by Category -->
        @if($byCategory->isNotEmpty())
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-bold text-gray-800 mb-4">Vendas por Categoria</h3>
            <div class="space-y-3">
                @php $maxCat = $byCategory->max('revenue'); @endphp
                @foreach($byCategory as $cat)
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-700 w-36 truncate">{{ $cat->category }}</span>
                    <div class="flex-1 bg-gray-100 rounded-full h-4 overflow-hidden">
                        <div class="bg-blue-500 h-4 rounded-full transition-all"
                            style="width: {{ $maxCat > 0 ? round(($cat->revenue / $maxCat) * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-gray-900 w-28 text-right">R$ {{ number_format($cat->revenue, 2, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@if(count($dateRange) > 0)
<script>
// Sales bar chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($dateRange, 'date')) !!},
        datasets: [{
            label: 'Faturamento (R$)',
            data: {!! json_encode(array_column($dateRange, 'revenue')) !!},
            backgroundColor: 'rgba(37, 99, 235, 0.7)',
            borderColor: 'rgba(37, 99, 235, 1)',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: (v) => 'R$ ' + v.toLocaleString('pt-BR', { minimumFractionDigits: 2 })
                }
            }
        }
    }
});
</script>
@endif

@if($byStatus->isNotEmpty())
<script>
const statusLabels = @json(\App\Models\Order::$statusLabels);
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = @json($byStatus);
const colors = ['#3B82F6','#10B981','#F59E0B','#EF4444','#6366F1','#14B8A6','#6B7280'];
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(k => statusLabels[k] || k),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: colors.slice(0, Object.keys(statusData).length),
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 } } }
        }
    }
});
</script>
@endif
@endsection
