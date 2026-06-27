@extends('layouts.app')

@section('content')

<div class="mb-6 text-center">
    <form action="{{ route('menu.search') }}" method="GET" class="inline-flex">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari menu..." class="border px-3 py-1 rounded-l focus:outline-none">
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-r">Cari</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($menus as $menu)
    <div class="bg-white p-4 rounded shadow text-center">
    <img src="{{ $menu->image ? asset($menu->image) : 'https://via.placeholder.com/200' }}"  class="w-full h-56 object-cover rounded mb-3">        
     <h3 class="font-bold">{{ $menu->name }}</h3>
        <p class="text-gray-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

        <div class="mt-2 flex justify-center space-x-2">
            <button class="bg-gray-300 px-2 rounded" onclick="updateCart({{ $menu->id }}, 'minus')">-</button>
            <span id="qty-{{ $menu->id }}" class="w-8 border text-center">0</span>
            <button class="bg-blue-500 text-white px-2 rounded" onclick="updateCart({{ $menu->id }}, 'plus')">+</button>
        </div>
    </div>
@endforeach
</div>

<div class="fixed bottom-4 right-4 flex space-x-2 z-10">
    <button onclick="checkout()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Pesan</button>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
let cart = JSON.parse(localStorage.getItem('cart') || '{}');

document.querySelectorAll('[id^="qty-"]').forEach(el => {
    const id = el.id.replace('qty-', '');
    el.innerText = cart[id] || 0;
});

function updateCart(menuId, action) {
    const url = action === 'minus' ? `/cart/minus/${menuId}` : `/cart/add/${menuId}`;
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        cart[menuId] = data[menuId] || 0;
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById('qty-' + menuId).innerText = cart[menuId];
    });
}

function checkout() {
    const name = prompt('Nama Anda?', 'Guest') || 'Guest';
    fetch('/cart/checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ customer_name: name })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            localStorage.removeItem('cart');
            window.location.href = '/order/' + data.order_id;
        }
    });
}
</script>
@endsection