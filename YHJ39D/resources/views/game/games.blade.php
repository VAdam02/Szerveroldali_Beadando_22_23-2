<h1>Fikcionális labdarúgó-bajnokság meccsei</h1>

<h2>Folyamatban lévő meccsek</h2>
@foreach ($games as $game)
    @if ($game->start < Carbon\Carbon::now() && $game->finished == false)
        <table class="game">
            <tr>
                <td rowspan="2"><img src="{{ $game->homeTeamLogo }}" alt="{{ $game->homeTeamName }}"></td>
                <td>Kezdés: {{ $game->start }}</td>
                <td rowspan="2"><img src="{{ $game->awayTeamLogo }}" alt="{{ $game->awayTeamName }}"></td>
            </tr>
            <tr>
                <td>Aktuális eredmény:</td>
            </tr>
            <tr>
                <td>{{ $game->homeTeamShortName }}</td>
                <td>{{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}</td>
                <td>{{ $game->awayTeamShortName }}</td>
            </tr>
        </table>
    @endif
@endforeach

<h2>Elkövetkező és már lezárult meccsek</h2>
@foreach ($games as $game)
    @if ($game->start > Carbon\Carbon::now() || $game->finished)
        <table class="game">
            <tr>
                <td rowspan="2"><img src="{{ $game->homeTeamLogo }}" alt="{{ $game->homeTeamName }}"></td>
                <td>Kezdés: {{ $game->start }}</td>
                <td rowspan="2"><img src="{{ $game->awayTeamLogo }}" alt="{{ $game->awayTeamName }}"></td>
            </tr>
            <tr>
                <td>
                    @if ( $game->finished)
                        Eredmény:
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ $game->homeTeamShortName }}</td>
                <td>
                    @if ( $game->finished)
                    {{ $game->homeTeamScore }} : {{ $game->awayTeamScore }}
                    @endif
                </td>
                <td>{{ $game->awayTeamShortName }}</td>
            </tr>
        </table>
    @endif
@endforeach