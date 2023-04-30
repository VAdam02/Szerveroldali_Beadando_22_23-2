<x-withGames-layout :activeGames="$activeGames">

    <div class="border border-gray-400 rounded-lg overflow-hidden">
        <div class="bg-gray-100 py-3 px-4 flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ $team->name }} - {{ $team->shortname }}</h2>
            @can('edit', $team)
                <a href="{{ route('teams.edit', $team) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Szerkesztés</a>
            @endcan
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <h3 class="text-lg font-semibold mb-2">Csapat logó</h3>
                @if ($team->image == null)
                    <img class="w-32 h-32 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $team->name }}">
                @else
                    <img src="{{ Storage::url('images/' . $team->image) }}" class="w-32 h-32 object-cover rounded-full mx-auto" alt="{{ $team->name }}">
                @endif

                <h3 class="text-lg font-semibold mb-2">Mérkőzések</h3>
                <div class="grid grid-cols-1 gap-4">
                    @forelse ($team->games->sortByDesc('start') as $game)
                        @include('partials.game.card', ['game' => $game])
                    @empty
                    <p>Nincsenek mérkőzések</p>
                    @endforelse
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Játékosok</h3>
                @foreach ($team->players as $player)
                    @include('partials.player.card', ['player' => $player])
                @endforeach
            </div>
        </div>
    </div>
</x-withGames-layout>