<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Owner') - Mewek Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gray-800 text-white p-4 flex flex-col md:flex-row justify-between items-center shadow-md gap-3">
        <a href="{{ route('owner.dashboard') }}" class="font-bold text-2xl">🍽 Mewek Order <span class="text-xs font-normal text-gray-300">(Owner)</span></a>
        <div class="flex items-center space-x-4 text-sm">
            <a href="{{ route('owner.dashboard') }}" class="hover:underline {{ request()->routeIs('owner.dashboard') ? 'font-bold underline' : '' }}">Dashboard</a>
            <a href="{{ route('owner.menu.index') }}" class="hover:underline {{ request()->routeIs('owner.menu.*') ? 'font-bold underline' : '' }}">Kelola Menu</a>
            <a href="{{ route('owner.orders.index') }}" class="hover:underline {{ request()->routeIs('owner.orders.*') ? 'font-bold underline' : '' }}">Pesanan Masuk</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
