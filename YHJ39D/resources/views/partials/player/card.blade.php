<div class="justify-between items-center border-b py-2 flex flex-wrap p-4">
    <div class="w-1/3 mb-4 px-2">
        <p class="font-semibold">{{ $player->number }}. {{ $player->name }}</p>
        <p class="text-gray-600 text-sm">{{ $player->birthdate }}</p>
    </div>
    <div class="w-1/3 mb-4 px-2">
        <p>Gólok: {{ $player->goals }}</p>
        <p>Öngólok: {{ $player->ownGoals }}</p>
        <p>Sárga lapok: {{ $player->yellowCards }}</p>
        <p>Piros lapok: {{ $player->redCards }}</p>
    </div>
    <div class="w-1/3 mb-4 px-2">
        <form action="{{ route('teams.destroyPlayer', ['team' => $team, 'player' => $player]
        ) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Törlés</button>
        </form>
    </div>
</div>