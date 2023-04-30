<x-withGames-layout :activeGames="$activeGames">
    <div class="grid grid-cols-1 gap-4">
        <div class="max-w-2xl mx-auto mt-8">
            @include('partials.game.create')
        </div>
    </div>
</x-withGames-layout>