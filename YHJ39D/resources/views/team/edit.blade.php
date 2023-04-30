<x-withGames-layout :activeGames="$activeGames">
    <div class="grid grid-cols-2 gap-8">
        <div>
            <h3 class="text-2xl font-bold mt-4 mb-2">Csapat szerkesztése:</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="shadow-md rounded-md p-4 bg-gray-100">
                    <form action="{{ route('teams.edit', $team) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">Név</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="{{ $team->name }}">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="shortname">Rövid név</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="shortname" type="text" name="shortname" value="{{ $team->shortname }}">
                            @error('shortname')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="image">Logo (opcionális)</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="file" name="image">
                            @error('image')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Szerkesztés
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-2xl font-bold mt-4 mb-2">Játékos hozzáadása:</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="shadow-md rounded-md p-4 bg-gray-100">
                    <form action="{{ route('teams.addPlayer', $team) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">Név</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="number">Szám</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="number" type="number" name="number">
                            @error('number')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="birthdate">Születési dátum</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="birthdate" type="date" name="birthdate">
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
    </div>
</x-withGames-layout>