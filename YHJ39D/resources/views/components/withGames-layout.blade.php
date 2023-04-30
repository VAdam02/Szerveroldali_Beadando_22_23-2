<x-noGames-layout>
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
</x-noGames-layout>