<x-withGames-layout :activeGames=$activeGames>
    <h2 class="text-xl font-bold mb-4">Elkövetkező és már lezárult mérkőzések</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($notActiveGames as $game)
        @include ('partials.game.card', ['game' => $game])
        @endforeach
    </div>

    {{ $notActiveGames -> links() }}
</x-withGames-layout>