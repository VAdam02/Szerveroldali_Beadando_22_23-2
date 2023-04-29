<x-noGames-layout>
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">{{ __('Login') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="shadow-md rounded-md p-4 bg-gray-100">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-bold mb-2">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="border border-gray-400 p-2 w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-bold mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password" class="border border-gray-400 p-2 w-full @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="font-medium">{{ __('Remember Me') }}</label>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Login') }}</button>
                        @if (Route::has('password.request'))
                            <a class="inline-block align-baseline font-medium text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-noGames-layout>