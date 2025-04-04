<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your saved recipes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        <div class="flex justify-between mb-6">
            <!-- Button to Navigate to Favorites -->
            <div class="text-start">
                <a href="{{ route('favorites.index') }}" 
                   class="border rounded-full px-4 py-2 
                   {{ request()->is('favorites*') ? 'bg-black text-white border-white' : 'bg-white-500 text-black border-black' }}">
                   Favorites
                </a>
            </div>
        
            <!-- User Info -->
            <div class="text-end">
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Joined {{ $user->created_at->format('F Y') }}</p>
            </div>
        </div>
        
        
        <!-- User Recipes Section -->
        <h3 class="text-lg font-bold mt-4 section-divider">My Recipes</h3>
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5"> -->
        <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-5"> 
            @foreach ($recipes as $recipe)
            <div id="click" onclick="location.href = '/recipes/{{ $recipe->id }}'" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 flex flex-col items-start aspect-[1/1] w-full max-w-[280px] mx-auto relative">
                
                <!-- Display Image -->
                @if ($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" 
                        alt="{{ $recipe->title }}" 
                        class="w-full h-40 object-cover rounded-md aspect-square mb-3">
                @else
                    <div class="w-full h-40 bg-gray-300 rounded-md flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif

                <!-- Recipe Title -->
                <h2 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $recipe->title }}</h2>

                <!-- User and Date -->
                <div class="text-xs font-light text-gray-600 dark:text-gray-400">
                    <span>Posted {{ $recipe->created_at->diffForHumans() }} by</span>
                    <a href="#" class="text-blue-500 font-medium">{{ $recipe->user->name ?? 'Unknown' }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
