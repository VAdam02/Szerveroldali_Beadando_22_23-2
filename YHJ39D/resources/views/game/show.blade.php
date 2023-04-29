<x-guest-layout :activeGames=$activeGames>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="max-w-2xl mx-auto mt-8">
            <h2 class="text-3xl font-bold mb-2">Mérkőzés adatok:</h2>
            <ul class="list-disc pl-6">
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
            <h3 class="text-2xl font-bold mt-4 mb-2">Események:</h3>
            <ul class="list-disc pl-6">
                @foreach($game->events->sortByDesc('minute') as $event)
                <li class="mb-1">{{ $event->minute }}. perc, {{ $event->player->team->name }}, {{ $event->type }}, {{ $event->player->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>

</x-guest-layout>