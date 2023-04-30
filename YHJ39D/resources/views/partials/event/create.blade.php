@can('create', App\Models\Event::class)
    <h3 class="text-2xl font-bold mt-4 mb-2">Új esemény rögzítése:</h3>
    <div class="grid grid-cols-1 gap-6">
        <div class="shadow-md rounded-md p-4 bg-gray-100">
            <form action="{{ route('events.create') }}" method="POST">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <div class="form-group">
                    <label for="minute">Perc:</label>
                    <input type="number" class="form-control" name="minute" id="minute" min="1" max="90" value="{{ old('minute') }}">
                    @error('minute')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="type">Esemény típusa:</label>
                    <select class="form-control" name="type" id="type">
                        <option value="gól">Gól</option>
                        <option value="öngól">Öngól</option>
                        <option value="sárga lap">Sárga lap</option>
                        <option value="piros lap">Piros lap</option>
                    </select>
                    @error('type')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="player_id">Játékos:</label>
                    <select class="form-control" name="player_id" id="player_id">
                        @foreach($games->players($game) as $player)
                            <option value="{{ $player->id }}">{{ $player->team->name }}, {{ $player->name }}</option>
                        @endforeach
                    </select>
                    @error('player_id')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Rögzítés</button>
            </form>
        </div>
    </div>
@endcan