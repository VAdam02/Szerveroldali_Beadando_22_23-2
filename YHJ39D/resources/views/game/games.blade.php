<h1>Fikcionális labdarúgó-bajnokság meccsei</h1>

<h2>Folyamatban lévő meccsek</h2>
@foreach ($activeGames as $game)
    <table class="game">
        <tr>
            <td rowspan="2"><img src="{{ $game->homeTeam->image }}" alt="{{ $game->homeTeam->name }}"></td>
            <td>Kezdés: {{ $game->start }}</td>
            <td rowspan="2"><img src="{{ $game->awayTeam->image }}" alt="{{ $game->homeTeam->name }}"></td>
        </tr>
        <tr>
            <td>Aktuális eredmény:</td>
        </tr>
        <tr>
            <td>{{ $game->homeTeam->shortname }}</td>
            <td>{{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</td>
            <td>{{ $game->awayTeam->shortname }}</td>
        </tr>
    </table>
@endforeach

<h2>Elkövetkező és már lezárult meccsek</h2>
@foreach ($notActiveGames as $game)
    @if ($game->start > Carbon\Carbon::now() || $game->finished)
        <table class="game">
            <tr>
                <td rowspan="2"><img src="{{ $game->homeTeam->image }}" alt="{{ $game->homeTeam->name }}"></td>
                <td>Kezdés: {{ $game->start }}</td>
                <td rowspan="2"><img src="{{ $game->awayTeam->name }}" alt="{{ $game->awayTeam->name }}"></td>
            </tr>
            <tr>
                <td>
                    @if ( $game->finished)
                        Eredmény:
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ $game->homeTeam->shortname }}</td>
                <td>
                    @if ( $game->finished)
                    {{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}
                    @endif
                </td>
                <td>{{ $game->awayTeam->shortname }}</td>
            </tr>
        </table>
    @endif
@endforeach