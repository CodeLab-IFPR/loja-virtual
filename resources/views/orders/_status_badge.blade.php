@php
$colors = [
    'pending'    => 'bg-yellow-100 text-yellow-800',
    'processing' => 'bg-blue-100 text-blue-800',
    'accepted'   => 'bg-green-100 text-green-800',
    'rejected'   => 'bg-red-100 text-red-800',
    'shipped'    => 'bg-indigo-100 text-indigo-800',
    'delivered'  => 'bg-teal-100 text-teal-800',
    'cancelled'  => 'bg-gray-100 text-gray-600',
];
$labels = \App\Models\Order::$statusLabels;
$cls = $colors[$status] ?? 'bg-gray-100 text-gray-600';
$lbl = $labels[$status] ?? $status;
@endphp
<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">{{ $lbl }}</span>
