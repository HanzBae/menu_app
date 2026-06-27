<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Cafe Hanz')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4 flex justify-between items-center shadow-md">
        <a href="{{ route('menu.index') }}" class="font-bold text-2xl">🍽 Cafe Hanz</a>
        <a href="{{ route('login') }}" class="text-xs text-blue-100 hover:text-white hover:underline">Login Owner</a>
    </nav>

    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 py-6">
        @yield('content')
    </div>
</body>
</html>