@extends('layouts.owner')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Menu Baru</h1>

    <form action="{{ route('owner.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="name">Nama Menu</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Contoh: Nasi Goreng"
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="description">Deskripsi (Opsional)</label>
            <textarea
                name="description"
                id="description"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                rows="3"
                placeholder="Deskripsi singkat menu..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="price">Harga (Rp)</label>
            <input
                type="number"
                name="price"
                id="price"
                value="{{ old('price') }}"
                required
                min="0"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Contoh: 25000"
            >
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2" for="image">Foto Menu (Opsional)</label>
            <input
                type="file"
                name="image"
                id="image"
                accept="image/*"
                class="w-full text-gray-600"
            >
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, GIF (max 2MB)</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-medium shadow">
                Simpan Menu
            </button>
            <a href="{{ route('owner.menu.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection