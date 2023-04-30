<x-withGames-layout :activeGames="$activeGames">

    <div class="border border-gray-400 rounded-lg overflow-hidden">
        <div class="bg-gray-100 py-3 px-4">
            <h2 class="text-lg font-semibold">{{ $team->name }}</h2>
        </div>
        <div class="flex flex-wrap p-4">
            <div class="w-full md:w-1/3 lg:w-1/3 mb-4 px-2">
                <h3 class="text-lg font-semibold mb-2">Csapat logó</h3>
                @if ($team->image == null)
                <img class="w-32 h-32 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $team->name }}">
                @else
                <img src="{{ Storage::url('images/' . $team->image) }}" class="w-32 h-32 object-cover rounded-full mx-auto" alt="{{ $team->name }}">
                @endif

                <h3 class="text-lg font-semibold mb-2">Mérkőzések</h3>
                @forelse ($team->games->sortByDesc('start') as $game)
                <div class="mb-4">
                    <p class="font-semibold">{{ $game->start }}</p>
                    @if ($game->finished)
                    <p class="mb-2">{{ $game->homeTeam->shortname }} {{ $game->homeTeamScore }} - {{ $game->awayTeamScore }} {{ $game->awayTeam->shortname }}</p>
                    <p class="text-gray-600 font-semibold">Befejezve</p>
                    @elseif ($game->start < now())
                    <p class="mb-2">{{ $game->homeTeam->shortname }} {{ $game->homeTeamScore }} - {{ $game->awayTeamScore }} {{ $game->awayTeam->shortname }}</p>
                    <p class="text-blue-500 font-semibold">Folyamatban</p>
                    @else
                    <p class="mb-2">{{ $game->homeTeam->shortname }} - {{ $game->awayTeam->shortname }}</p>
                    <p class="text-gray-600 font-semibold">Még hátra van</p>
                    @endif
                </div>
                @empty
                <p>Nincsenek mérkőzések</p>
                @endforelse
            </div>
            <div class="w-full md:w-2/3 lg:w-2/3 mb-4 px-2">
                <h3 class="text-lg font-semibold mb-2">Játékosok</h3>
                @foreach ($team->players as $player)
                    <div class="justify-between items-center border-b py-2 flex flex-wrap p-4">
                        <div class="w-2/5 mb-4 px-2">
                            <p class="font-semibold">{{ $player->number }}. {{ $player->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $player->birthdate }}</p>
                        </div>
                        <div class="w-2/5 mb-4 px-2">
                            <p>Gólok: {{ $player->goals }}</p>
                            <p>Öngólok: {{ $player->ownGoals }}</p>
                            <p>Sárga lapok: {{ $player->yellowCards }}</p>
                            <p>Piros lapok: {{ $player->redCards }}</p>
                        </div>
                        <div class="w-1/5 mb-4 px-2">
                            <form action="{{ route('teams.destroyPlayer', ['team' => $team, 'player' => $player]
                            ) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Törlés</button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    @can('edit', $team)
        <a href="{{ route('teams.edit', $team) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Szerkesztés</a>
    @endcan
</x-withGames-layout>