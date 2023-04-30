<div class="border border-gray-400 rounded-lg overflow-hidden">
    <div class="flex justify-center items-center bg-gray-100 py-3">
        <div class="w-1/3 text-center">
            @if ($team->image == null)
            <img class="w-16 h-16 object-cover rounded-full mx-auto" src="https://via.placeholder.com/150" alt="{{ $team->name }}">
            @else
            <img src="{{ Storage::url('images/' . $team->image) }}" class="w-16 h-16 object-cover rounded-full mx-auto" alt="{{ $team->name }}">
            @endif
            <p class="font-semibold">{{ $team->shortname }}</p>
        </div>
        <div class="w-2/3 text-center">
            <p class="text-gray-600">Csapatnév:</p>
            <p class="font-semibold">{{ $team->name }}</p>
            <a href="{{ route('teams.show', ['team' => $team]) }}" class="text-blue-500 hover:underline">Részletek</a>
        </div>
    </div>
</div>