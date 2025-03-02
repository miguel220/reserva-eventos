<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
    <div id="app" class="flex h-screen">
        <!-- Sidebar (aparece apenas para rotas admin) -->
        @if (request()->is('admin/*'))
            <div class="w-64 bg-gray-800 text-white p-4">
                <h2 class="text-2xl font-semibold mb-6">Admin</h2>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Dashboard</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.events') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Eventos</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.users') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Usuários</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-lg hover:bg-gray-700 p-2 rounded">Configurações</a>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex-1 @if (!request()->is('admin/*')) w-full @endif">
            @yield('content')
        </div>
    </div>
</body>
</html>