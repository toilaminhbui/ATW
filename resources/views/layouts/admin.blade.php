<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Monet</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans text-gray-900 h-screen flex overflow-hidden">

    <aside class="w-64 flex-shrink-0 hidden md:block">
        @include('layouts.admin.sidebar')
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        
        <div class="h-16 bg-white shadow-sm z-10">
            @include('layouts.admin.header')
        </div>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>