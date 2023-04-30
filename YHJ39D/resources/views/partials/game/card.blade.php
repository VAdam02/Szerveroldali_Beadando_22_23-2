<div class="border border-gray-400 rounded-lg overflow-hidden">
    <div class="flex justify-center items-center bg-gray-100 py-3">
        <div class="w-1/3 text-center">
            @if ($game->homeTeam->image == null)
            <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
            @else
            <img src="{{ Storage::url('images/' . $game->homeTeam->image) }}" class="w-16 h-16 object-cover rounded-full mx-auto" alt="{{ $game->homeTeam->name }}">
            @endif
            <a class="font-semibold" href="{{ route('teams.show', ['team' => $game->homeTeam]) }}">{{ $game->homeTeam->shortname }}</a>
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
            <a class="font-semibold" href="{{ route('teams.show', ['team' => $game->awayTeam]) }}">{{ $game->awayTeam->shortname }}</a>
        </div>
    </div>
</div>