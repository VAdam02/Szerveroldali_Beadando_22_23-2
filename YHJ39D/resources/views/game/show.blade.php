<x-withGames-layout :activeGames="$activeGames">
    <div class="grid grid-cols-1 gap-4">
        <div class="max-w-2xl mx-auto mt-8">
            <h2 class="text-3xl font-bold mb-2">Mérkőzés adatok:</h2>
            <div class="grid grid-cols-1 gap-6">
                <ul class="list-disc pl-6 shadow-md rounded-md p-4 bg-gray-100">
                    <li class="mb-1">ID: {{ $game->id }}</li>
                    <li class="mb-1">Kezdési idő: {{ $game->start }}</li>
                    <li class="mb-1">Befejezve: {{ $game->finished ? 'Igen' : 'Nem' }}</li>
                    <li class="mb-1">Hazai csapat
                        @include ('partials.team.card', ['team' => $game->homeTeam])</li>
                    <li class="mb-1">Vendég csapat
                        @include ('partials.team.card', ['team' => $game->awayTeam])</li>
                    @if ($game->start < now())
                        <li class="mb-1">Eredmény: {{ $game->homeTeamScore }} - {{ $game->awayTeamScore }}</li>
                    @else
                        <li class="mb-1">Eredmény: Még nem kezdődött el</li>
                    @endif
                </ul>
            </div>

            <div class="grid grid-cols-3 gap-6 text-center">
                @can('finish', $game)
                @if ($game->start < now() && !$game->finished)
                    <form action="{{ route('games.finish', $game) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Meccs lezárása</button>
                    </form>
                @endif
                @endcan

                @can('edit', $game)
                    <a href="{{ route('games.edit', $game) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Szerkesztés</a>
                @endcan

                @can('delete', $game)
                @if ($game->events == null || $game->events->count() == 0)
                    <form action="{{ route('games.destroy', $game) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Törlés</button>
                    </form>
                @endif
                @endcan
            </div>

            <h3 class="text-2xl font-bold mt-4 mb-2">Események:</h3>
            <div class="grid grid-cols-1 gap-6">
                <ul class="list-disc pl-6 shadow-md rounded-md p-4 bg-gray-100">
                    @foreach($game->events->sortByDesc('minute') as $event)
                        @include ('partials.event.card', ['event' => $event])
                    @endforeach
                </ul>
            </div>
            
            @if ($game->start < now() && !$game->finished)
                @include ('partials.event.create', ['game' => $game])
            @endif
        </div>
    </div>
</x-withGames-layout>