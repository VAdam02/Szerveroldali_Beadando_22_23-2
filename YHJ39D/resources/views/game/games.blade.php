@vite(['resources/css/app.css', 'resources/js/app.js'])

<h1>Fikcionális labdarúgó-bajnokság meccsei</h1>

<h2>Folyamatban lévő meccsek</h2>
<div class="grid grid-cols-3 gap-3">
    @foreach ($activeGames as $game)
        <table class="mx-auto border border-gray-400 col-span-3 lg:col-span-1">
            <tr>
                <td rowspan="2" class="text-center">
                    @if ($game->homeTeam->image == null)
                        <img style="width: 100px; height: 100px" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                    @else
                        <img style="width: 100px; height: 100px" src="{{ $game->homeTeam->image }}" alt="{{ $game->homeTeam->name }}">
                    @endif
                </td>
                <td>Kezdés: {{ $game->start }}</td>
                <td rowspan="2" class="text-center">
                    @if ($game->awayTeam->image == null)
                        <img style="width: 100px; height: 100px" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                    @else
                        <img style="width: 100px; height: 100px" src="{{ $game->awayTeam->image }}" alt="{{ $game->homeTeam->name }}">
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">Aktuális eredmény:</td>
            </tr>
            <tr>
                <td class="text-center">{{ $game->homeTeam->shortname }}</td>
                <td class="text-center">{{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</td>
                <td class="text-center">{{ $game->awayTeam->shortname }}</td>
            </tr>
        </table>
@endforeach
</div>

<h2>Elkövetkező és már lezárult meccsek</h2>
<div class="grid grid-cols-3 gap-3">
    @foreach ($notActiveGames as $game)
        <table class="mx-auto border border-gray-400 col-span-3 lg:col-span-1">
            <tr>
                <td rowspan="2" class="text-center">
                    @if ($game->homeTeam->image == null)
                        <img style="width: 100px; height: 100px" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                    @else
                        <img style="width: 100px; height: 100px" src="{{ $game->homeTeam->image }}" alt="{{ $game->homeTeam->name }}">
                    @endif
                </td>
                <td>Kezdés: {{ $game->start }}</td>
                <td rowspan="2" class="text-center">
                    @if ($game->awayTeam->image == null)
                        <img style="width: 100px; height: 100px" src="https://via.placeholder.com/150" alt="{{ $game->homeTeam->name }}">
                    @else
                        <img style="width: 100px; height: 100px" src="{{ $game->awayTeam->image }}" alt="{{ $game->homeTeam->name }}">
                    @endif
                </td>
            </tr>
            <tr>
                @if ( $game->finished)
                    <td class="text-center">Eredmény:</td>
                @else
                    <td></td>
                @endif
            </tr>
            <tr>
                <td class="text-center">{{ $game->homeTeam->shortname }}</td>
                <td class="text-center">{{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</td>
                <td class="text-center">{{ $game->awayTeam->shortname }}</td>
            </tr>
        </table>
@endforeach
</div>

{{ $notActiveGames -> links() }}