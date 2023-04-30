<x-withGames-layout :activeGames="$activeGames">

    <?php
    echo $team;
    ?>

<div class="border border-gray-400 rounded-lg overflow-hidden">
    <div class="bg-gray-100 py-3 px-4">
        <h2 class="text-lg font-semibold">{{ $team->name }}</h2>
    </div>
    <div class="flex flex-wrap p-4">
        <div class="w-full md:w-1/2 lg:w-1/3 mb-4 px-2">
            <h3 class="text-lg font-semibold mb-2">Mérkőzések</h3>
            @forelse ($team->games->sortByDesc('start') as $game)
            <div class="mb-4">
                <p class="font-semibold">{{ $game->start }}</p>
                <p class="mb-2">{{ $game->homeTeam->shortname }} {{ $game->homeTeamScore }} - {{ $game->awayTeamScore }} {{ $game->awayTeam->shortname }}</p>
                @if ($game->finished)
                <p class="text-gray-600 font-semibold">Befejezve</p>
                @elseif ($game->start < now())
                <p class="text-blue-500 font-semibold">Folyamatban</p>
                @else
                <p class="text-gray-600 font-semibold">Még hátra van</p>
                @endif
            </div>
            @empty
            <p>Nincsenek mérkőzések</p>
            @endforelse
        </div>
        <div class="w-full md:w-1/2 lg:w-2/3 mb-4 px-2">
            <h3 class="text-lg font-semibold mb-2">Játékosok</h3>
            @forelse ($team->players as $player)
            <div class="flex justify-between items-center border-b py-2">
                <div>
                    <p class="font-semibold">{{ $player->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $player->birthdate }}</p>
                </div>
                <div>
                    <p>Gólok: {{ $player->goals }}</p>
                    <p>Öngólok: {{ $player->ownGoals }}</p>
                    <p>Sárga lapok: {{ $player->yellowCards }}</p>
                    <p>Piros lapok: {{ $player->redCards }}</p>
                </div>
            </div>
            @empty
            <p>Nincsenek játékosok</p>
            @endforelse
        </div>
    </div>
</div>

</x-withGames-layout>