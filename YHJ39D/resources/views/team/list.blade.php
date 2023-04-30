<x-withGames-layout :activeGames="$activeGames">

    <h2 class="text-xl font-bold mb-4">Bajnokságon résztvevő csapatok</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($teams as $team)
        @include('partials.team.card', ['team' => $team])
        @endforeach
    </div>

    {{ $teams->links() }}
</x-withGames-layout>