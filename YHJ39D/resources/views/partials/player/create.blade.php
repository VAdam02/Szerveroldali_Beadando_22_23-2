<div>
    <h3 class="text-2xl font-bold mt-4 mb-2">Játékos hozzáadása</h3>
    <div class="grid grid-cols-1 gap-6">
        <div class="shadow-md rounded-md p-4 bg-gray-100">
            <form action="{{ route('teams.addPlayer', $team) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="name">Név</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="playername" value="{{ old('playername') }}">
                    @error('playername')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="number">Mezszám</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="number" type="number" min="1" max="99" name="number" value="{{ old('number') }}">
                    @error('number')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="birthdate">Születési dátum</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="birthdate" type="date" max="{{ date('Y-m-d') }}" name="birthdate" value="{{ old('birthdate') }}">
                    @error('birthdate')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Hozzáadás
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>