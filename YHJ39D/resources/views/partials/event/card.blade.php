<li class="mb-1">
    @can('delete', $event)
    @if ($game->start < now() && !$game->finished)
        <form action="{{ route('events.destroy', ['event' => $event]) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:underline font-bold">Törlés</button>
        </form>
    @endif
    @endcan
    {{ $event->minute }}. perc, {{ $event->player->team->name }}, {{ $event->type }}, {{ $event->player->name }}
</li>