<x-noGames-layout>
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">{{ __('Register') }}</h2>
        <div class="grid grid-cols-1 gap-6">
            <div class="shadow-md rounded-md p-4 bg-gray-100">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">{{ __('Name') }}</label>
                        <input id="name" type="text" class="border border-gray-400 p-2 w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="border border-gray-400 p-2 w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password" class="border border-gray-400 p-2 w-full @error('password') border-red-500 @enderror" name="password" autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password-confirm" class="block text-gray-700 font-bold mb-2">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="border border-gray-400 p-2 w-full" name="password_confirmation" autocomplete="new-password">
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-noGames-layout>