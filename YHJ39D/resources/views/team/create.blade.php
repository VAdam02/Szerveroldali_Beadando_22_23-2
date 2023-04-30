<x-withGames-layout :activeGames="$activeGames">
    <div class="grid grid-cols-1 gap-4">
        <div class="max-w-2xl mx-auto mt-8">
            <h3 class="text-2xl font-bold mt-4 mb-2">Új csapat létrehozása:</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="shadow-md rounded-md p-4 bg-gray-100">
                    <form action="{{ route('teams.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="name">Név</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name">
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="shortname">Rövid név</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="shortname" type="text" name="shortname">
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
                                Hozzáadás
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-withGames-layout>