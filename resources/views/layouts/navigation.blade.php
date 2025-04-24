<nav x-data="{ open: false }" class="fixed top-0 inset-x-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center w-full">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            
                <!-- Navigation Links (Optional, if you have other links) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Add other navigation links here if needed -->
                </div>

                <div class="flex-1 flex justify-center items-center">
                    <!-- Desktop Search Form -->
                    <form action="{{ route('recipes.index') }}" method="GET" class="w-full max-w-md hidden md:block">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"></path>
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="search"
                                placeholder="Search"
                                value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 rounded-full bg-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            >
                        </div>
                    </form>
                
                    <!-- Mobile Search Button and Dropdown -->
                    <div x-data="{ open: false }" class="relative md:hidden ml-2">
                        <!-- Yellow Icon Button -->
                        <button @click="open = !open" class="p-2 bg-yellow-500 rounded-full text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                
                        <!-- Dropdown Search Input -->
                        <div x-show="open" @click.outside="open = false"
                             x-transition
                             class="absolute right-0 mt-2 bg-white p-2 rounded shadow w-64">
                            <form action="{{ route('recipes.index') }}" method="GET">
                                <input type="text" name="search" placeholder="Search recipes..."
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            </form>
                        </div>
                    </div>
                </div>
                
                
            
                <!-- Post Button (Moved to the right) -->
                <div class="ml-auto">
                    <a href="{{ route('recipes.create') }}" 
                       class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium h-8 px-3 rounded shadow-md my-1 space-x-1">
                        <x-zondicon-upload class="w-4 h-4" />
                        {{-- <span>Upload</span> --}}
                    </a>
                </div>
            </div>
            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show', ['user' => auth()->user()->id])">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Account Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        {{-- <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /> --}}
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">

                <x-dropdown-link :href="route('profile.show', ['user' => auth()->user()->id])">
                    {{ __('Profile') }}
                </x-dropdown-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Account Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
