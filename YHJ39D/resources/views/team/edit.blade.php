<x-withGames-layout :activeGames="$activeGames">
    <div class="grid md:grid-cols-2 grid-cols-1 gap-8">
        @include('partials.team.edit', ['team' => $team])
        @include('partials.player.create', ['team' => $team])
    </div>
</x-withGames-layout>