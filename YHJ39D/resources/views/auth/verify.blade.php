<x-noGames-layout>
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">{{ __('Verify Your Email Address') }}</h2>
        <div class="grid grid-cols-1 gap-6">
            <div class="shadow-md rounded-md p-4 bg-gray-100">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>
</x-noGames-layout>
