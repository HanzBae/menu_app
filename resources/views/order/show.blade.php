@extends('layouts.app')
@section('title', 'Nota Pesanan #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Nota Pesanan #{{ $order->id }}</h1>
                <p class="text-gray-600 mt-1">Pemesan: <span class="font-medium">{{ $order->customer_name }}</span></p>
                <p class="text-gray-600">Status: 
                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Tabel Detail -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-700">Menu</th>
                        <th class="px-4 py-3 font-semibold text-gray-700 text-center">Jumlah</th>
                        <th class="px-4 py-3 font-semibold text-gray-700 text-right">Harga</th>
                        <th class="px-4 py-3 font-semibold text-gray-700 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php $total = 0; @endphp
                    @foreach($order->items as $item)
                        @php 
                            $subtotal = $item->price * $item->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $item->menu->name }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t border-gray-200">
                    <tr class="font-bold bg-gray-50">
                        <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                        <td class="px-4 py-3 text-right text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="mt-8 flex justify-between">
            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414zm1.414-1.414a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414zm-3.12-5.82a1 1 0 011.414 0L12 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Menu
            </a>
        </div>
    </div>
</div>
@endsection