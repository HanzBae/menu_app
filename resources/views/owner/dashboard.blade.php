@extends('layouts.owner')

@section('title', 'Dashboard')

@section('content')

<h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Owner</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-gray-500">Total Menu</p>
        <p class="text-3xl font-bold text-blue-600">{{ $totalMenu }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-gray-500">Pesanan Pending</p>
        <p class="text-3xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6 text-center">
        <p class="text-gray-500">Pesanan Selesai</p>
        <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('owner.menu.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition block">
        <h2 class="text-lg font-bold text-gray-800 mb-1">🍽 Kelola Menu</h2>
        <p class="text-gray-500 text-sm">Tambah, edit, atau hapus menu yang ditampilkan ke customer.</p>
    </a>
    <a href="{{ route('owner.orders.index') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition block">
        <h2 class="text-lg font-bold text-gray-800 mb-1">🧾 Pesanan Masuk</h2>
        <p class="text-gray-500 text-sm">Lihat & tandai pesanan customer yang sudah selesai diproses.</p>
    </a>
</div>

@endsection
