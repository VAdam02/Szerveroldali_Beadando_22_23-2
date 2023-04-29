<x-withGames-layout :activeGames="$activeGames">
    <div class="grid grid-cols-1 gap-4">
        <div class="max-w-2xl mx-auto mt-8">
            <h2 class="text-3xl font-bold mb-2">Mérkőzés adatok:</h2>
            <div class="grid grid-cols-1 gap-6">
                <ul class="list-disc pl-6 shadow-md rounded-md p-4 bg-gray-100">
                    <li class="mb-1">ID: {{ $game->id }}</li>
                    <li class="mb-1">Kezdési idő: {{ $game->start }}</li>
                    <li class="mb-1">Befejezve: {{ $game->finished ? 'Igen' : 'Nem' }}</li>
                    <li class="mb-1">Hazai csapat: {{ $game->homeTeam->name }}</li>
                    <li class="mb-1">Vendég csapat: {{ $game->awayTeam->name }}</li>
                    @if ($game->start < now())
                        <li class="mb-1">Eredmény: {{ $game->homeTeamScore }} - {{ $game->awayTeamScore }}</li>
                    @else
                        <li class="mb-1">Eredmény: Még nem kezdődött el</li>
                    @endif
                </ul>
            </div>
            <h3 class="text-2xl font-bold mt-4 mb-2">Események:</h3>
            <div class="grid grid-cols-1 gap-6">
                <ul class="list-disc pl-6 shadow-md rounded-md p-4 bg-gray-100">
                    @foreach($game->events->sortByDesc('minute') as $event)
                        <li class="mb-1">
                            @can('delete', $event)
                            @if ($game->start < now() && !$game->finished)
                                <form action="{{ route('events.destroy', ['event' => $event]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline font-bold">Törlés</button>
                                </form>
                            @endif
                            @endcan
                            {{ $event->minute }}. perc, {{ $event->player->team->name }}, {{ $event->type }}, {{ $event->player->name }}
                        </li>
                    @endforeach
                </ul>
            </div>

            @can('finish', $game)
            @if ($game->start < now() && !$game->finished)
                <form action="{{ route('games.finish', $game) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Meccs lezárása</button>
                </form>
            @endif
            @endcan
            
            @can('create', App\Models\Event::class)
            @if ($game->start < now() && !$game->finished)
            <h3 class="text-2xl font-bold mt-4 mb-2">Új esemény rögzítése:</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="shadow-md rounded-md p-4 bg-gray-100">
                    <form action="{{ route('events.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        <div class="form-group">
                            <label for="minute">Perc:</label>
                            <input type="number" class="form-control" name="minute" id="minute" min="1" max="90">
                            @error('minute')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Esemény típusa:</label>
                            <select class="form-control" name="type" id="type">
                                <option value="gól">Gól</option>
                                <option value="öngól">Öngól</option>
                                <option value="sárga lap">Sárga lap</option>
                                <option value="piros lap">Piros lap</option>
                            </select>
                            @error('type')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="player_id">Játékos:</label>
                            <select class="form-control" name="player_id" id="player_id">
                                @foreach($games->players($game) as $player)
                                    <option value="{{ $player->id }}">{{ $player->team->name }}, {{ $player->name }}</option>
                                @endforeach
                            </select>
                            @error('player_id')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Rögzítés</button>
                    </form>
                </div>
            </div>
            @endif
            @endcan
        </div>
    </div>
</x-withGames-layout>