<x-withGames-layout :activeGames=$activeGames>
    <h2 class="text-xl font-bold mb-4">Elkövetkező és már lezárult mérkőzések:</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($notActiveGames as $game)
        <div class="border border-gray-400 rounded-lg overflow-hidden">
            <div class="flex justify-center items-center bg-gray-100 py-3">
                <div class="w-1/3 text-center">
                    @if ($game->homeTeam->image == null)
                    <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                    @else
                    <img src="{{ Storage::url('images/' . $game->homeTeam->image) }}" class="w-16 h-16 object-cover rounded-full mx-auto" alt="{{ $game->homeTeam->name }}">
                    @endif
                    <p class="font-semibold">{{ $game->homeTeam->shortname }}</p>
                </div>
                <div class="w-1/3 text-center">
                    <p class="text-gray-600">Kezdés:</p>
                    <p class="font-semibold">{{ $game->start }}</p>
                    @if ( $game->finished)
                        <p class="font-semibold">Eredmény: {{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</p>
                    @else 
                        <p class="font-semibold">Még nem kezdődött el</p>
                    @endif
                    <a href="{{ route('games.show', ['game' => $game]) }}" class="text-blue-500 hover:underline">Megtekintés</a>
                </div>
                <div class="w-1/3 text-center">
                    @if ($game->awayTeam->image == null)
                    <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $game->awayTeam->name }}">
                    @else
                    <img src="{{ Storage::url('images/' . $game->awayTeam->image) }}" class="w-16 h-16 object-cover rounded-full mx-auto" alt="{{ $game->awayTeam->name }}">
                    @endif
                    <p class="font-semibold">{{ $game->awayTeam->shortname }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $notActiveGames -> links() }}
</x-withGames-layout>