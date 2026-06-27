@extends('layouts.owner')

@section('title', 'Kelola Menu')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kelola Menu</h1>
    <a href="{{ route('owner.menu.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium shadow">
        + Tambah Menu
    </a>
</div>

@if($menus->isEmpty())
    <div class="text-center py-12 bg-white rounded-xl shadow">
        <p class="text-gray-500 text-lg">📭 Belum ada menu. Tambahkan menu pertama Anda.</p>
    </div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($menus as $menu)
    <div class="bg-white p-4 rounded shadow text-center">
        <img src="{{ $menu->image ? asset($menu->image) : 'https://via.placeholder.com/200' }}" class="w-full h-56 object-cover rounded mb-3">
        <h3 class="font-bold">{{ $menu->name }}</h3>
        <p class="text-gray-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

        <div class="mt-3 space-x-2">
            <a href="{{ route('owner.menu.edit', $menu) }}" class="bg-yellow-500 text-white text-sm px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="{{ route('owner.menu.destroy', $menu) }}" method="POST" class="inline" onsubmit="return confirm('Hapus menu ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 text-white text-sm px-3 py-1 rounded hover:bg-red-600">Hapus</button>
            </form>
        </div>
    </div>
@endforeach
</div>
@endif

@endsection
