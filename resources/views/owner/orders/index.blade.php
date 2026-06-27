@extends('layouts.owner')
@section('title','Pesanan Masuk')

@section('content')
<div class="max-w-4xl mx-auto px-0 md:px-6 py-2">
    <h1 class="text-3xl font-bold text-center mb-8 text-indigo-700">Pesanan Masuk</h1>

    @if($orders->where('status', 'pending')->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl shadow">
            <p class="text-gray-500 text-lg">📭 Belum ada pesanan.</p>
        </div>
    @else
        @foreach($orders->where('status', 'pending') as $order)
        <div id="order-{{ $order->id }}" class="bg-white rounded-xl shadow-lg p-6 mb-6 hover:shadow-xl transition">
            <!-- Header Order -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Nota #{{ $order->id }}</h2>
                    <p class="text-gray-600">Pemesan: <span class="font-medium">{{ $order->customer_name }}</span></p>
                    <p class="text-gray-600">Dibuat: {{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <button
                    onclick="completeOrder({{ $order->id }})"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold shadow-md transition flex items-center gap-1">
                    ✅ Selesai
                </button>
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
        </div>
        @endforeach
    @endif
</div>

<script>
function completeOrder(orderId) {
    if (!confirm('Yakin tandai pesanan ini sebagai selesai?')) return;

    // Catatan: sebelumnya URL ini salah (/order/complete/{id}), sudah diperbaiki
    // supaya cocok dengan route owner.orders.complete -> /owner/orders/{order}/complete
    fetch(`/owner/orders/${orderId}/complete`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            const el = document.getElementById('order-' + orderId);
            if (el) el.remove();
            if (document.querySelectorAll('[id^="order-"]').length === 0) {
                location.reload();
            }
        }
    })
    .catch(err => console.error(err));
}
</script>
@endsection
