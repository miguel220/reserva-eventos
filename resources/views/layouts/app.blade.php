<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
</head>
<body class="font-sans antialiased">
    <div id="app" class="flex h-screen">
        
        @if (auth()->user() && auth()->user()->is_admin && auth()->user()->is_producer)
            <div class="w-64 bg-gray-800 text-white p-4">
                <h2 class="text-2xl font-semibold mb-6">
                    @if(isset(auth()->user()->name))
                        {{ auth()->user()->name }}
                    @else
                        User not found.
                    @endif
                </h2>
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
                        <a href="{{ route('escalas.index') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('escalas.consultar') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Consultar Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-lg hover:bg-gray-700 p-2 rounded">Configurações</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
                    </form>
                </ul>
            </div>
        @elseif (auth()->user() && auth()->user()->is_producer)
            <div class="w-64 bg-gray-800 text-white p-4">
                <h2 class="text-2xl font-semibold mb-6">
                    @if(isset(auth()->user()->name))
                        {{ auth()->user()->name }}
                    @else
                        User not found.
                    @endif
                </h2>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Dashboard</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.users') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Usuários</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('escalas.index') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('escalas.consultar') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Consultar Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-lg hover:bg-gray-700 p-2 rounded">Configurações</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
                    </form>
                </ul>
            </div>
        @elseif (auth()->user() && auth()->user()->is_admin)
            <div class="w-64 bg-gray-800 text-white p-4">
                <h2 class="text-2xl font-semibold mb-6">
                    @if(isset(auth()->user()->name))
                        {{ auth()->user()->name }}
                    @else
                        User not found.
                    @endif
                </h2>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Dashboard</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('admin.events') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Eventos</a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('escalas.consultar') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Consultar Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-lg hover:bg-gray-700 p-2 rounded">Configurações</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
                    </form>
                </ul>
            </div>
        @else
            <div class="w-64 bg-gray-800 text-white p-4">
                <h2 class="text-2xl font-semibold mb-6">
                    @if(isset(auth()->user()->name))
                        {{ auth()->user()->name }}
                    @else
                        User not found.
                    @endif
                </h2>
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('escalas.consultar') }}" class="text-lg hover:bg-gray-700 p-2 rounded">Consultar Escalas</a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="text-lg hover:bg-gray-700 p-2 rounded">Configurações</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Sair</button>
                    </form>
                </ul>
            </div>        
        @endif

        <!-- Main Content -->
        <div class="flex-1">
            @yield('content')

            <!-- Scripts -->
            <script src="{{ asset('js/app.js') }}"></script> <!-- Se estiver usando Laravel Mix ou outros -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery é necessário para Select2 -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            @yield('scripts')
        </div>
    </div>
</body>
</html>