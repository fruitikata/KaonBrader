<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Google Sign Up -->
        <a href="{{ url('/auth/google') }}"
           class="flex items-center justify-center gap-3 bg-white border border-gray-300 hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded w-full mb-6">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="h-5 w-5">
            <span>Sign up with Google</span>
        </a>

        <!-- OR Divider -->
        <div class="my-6 flex items-center">
            <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
            <span class="mx-4 text-gray-500 dark:text-gray-400">OR</span>
            <hr class="flex-grow border-t border-gray-300 dark:border-gray-600">
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600"
                          type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 dark:focus:border-yellow-600 dark:focus:ring-yellow-600"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-3 bg-yellow-500 hover:bg-yellow-600 text-white">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
