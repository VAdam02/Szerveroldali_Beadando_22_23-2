<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="container mx-auto py-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Fikcionális labdarúgó-bajnokság hivatalos oldala</h1>
                <div class="max-w-min md:min-w-max">
                    @guest
                    <span class="text-gray-500">Vendég nézet</span>
                    <a href="{{ route('login') }}" class="ml-4 text-blue-500 hover:text-blue-700 transition duration-300 ease-in-out">Bejelentkezés</a>
                    <a href="{ route('register') }}" class="ml-4 text-blue-500 hover:text-blue-700 transition duration-300 ease-in-out">Regisztráció</a>
                    @endguest
                    @auth
                    <div class="flex items-center">
                        <span class="mr-4">Szia, {{ Auth::user()->name }}!</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-block px-4 py-2 bg-red-700 hover:bg-red-900 text-white rounded transition duration-300 ease-in-out">Kijelentkezés</button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="{{ route('home') }}" class="text-xl font-medium text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out">Főoldal</a>
                <a href="{{ route('list') }}" class="text-xl font-medium text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out">Mérkőzések</a>
                <a href="{ route('game.teams') }}" class="text-xl font-medium text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out">Csapatok</a>
                <a href="{ route('game.table') }}" class="text-xl font-medium text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out">Tabella</a>
                <a href="{ route('game.favourites') }}" class="text-xl font-medium text-gray-800 hover:text-blue-500 transition duration-300 ease-in-out">Kedvenceim</a>
            </div>
        </header>
        
        <h2 class="text-xl font-bold mb-4">Folyamatban lévő mérkőzések:</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($activeGames as $game)
            <div class="border border-gray-400 rounded-lg overflow-hidden">
                <div class="flex justify-center items-center bg-gray-100 py-3">
                    <div class="w-1/3 text-center">
                        @if ($game->homeTeam->image == null)
                        <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                        @else
                        <img class="w-16 h-16 object-cover rounded-full mx-auto" src="{{ $game->homeTeam->image }}" alt="{{ $game->homeTeam->name }}">
                        @endif
                        <p class="font-semibold">{{ $game->homeTeam->shortname }}</p>
                    </div>
                    <div class="w-1/3 text-center">
                        <p class="text-gray-600">Kezdés:</p>
                        <p class="font-semibold">{{ $game->start }}</p>
                        <p class="font-semibold">Aktuális eredmény:</p><p class="font-semibold">{{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</p>
                        <a href="{{ route('games.show', ['game' => $game]) }}" class="text-blue-500 hover:underline">Megtekintés</a>
                    </div>
                    <div class="w-1/3 text-center">
                        @if ($game->awayTeam->image == null)
                        <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $game->awayTeam->name }}">
                        @else
                        <img class="w-16 h-16 object-cover rounded-full mx-auto" src="{{ $game->awayTeam->image }}" alt="{{ $game->awayTeam->name }}">
                        @endif
                        <p class="font-semibold">{{ $game->awayTeam->shortname }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 lg:grid lg:grid-cols-3 lg:gap-6">
            <div class="lg:col-span-3">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
