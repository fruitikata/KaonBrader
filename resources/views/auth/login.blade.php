<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-yellow-600 shadow-sm focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Login Button & Forgot Password -->
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-yellow-500 hover:bg-yellow-600 text-white">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- OR Divider -->
        <div class="my-6 flex items-center">
            <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
            <span class="mx-4 text-gray-500 dark:text-gray-400">OR</span>
            <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
        </div>

        <!-- Login with Google -->
        <a href="{{ url('login/google') }}"
           class="flex items-center justify-center gap-3 bg-white border border-gray-300 hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded w-full">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="h-5 w-5">
            <span>Login with Google</span>
        </a>
    </form>
</x-guest-layout>
