@php
    $isFavoritesPage = request()->is('favorites*');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your saved recipes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        <div class="flex justify-between mb-6">
            <!-- Button to Navigate to Favorites -->
            <!--<div class="text-start">
                <a href="{{ route('favorites.index') }}" 
                   class="border rounded-full px-4 py-2 
                   {{ request()->is('favorites*') ? 'bg-black text-white border-white' : 'bg-white-500 text-black border-black' }}">
                   Favorites
                </a>
            </div>-->
            <button onclick="window.location.href='{{ route('favorites.index') }}'"
                class="flex items-center gap-1 px-3 h-8 py-0 rounded-full text-sm
                {{ $isFavoritesPage ? 'bg-black text-white border border-white' : 'bg-white-500 text-black border border-black' }}">
            
                <svg xmlns="http://www.w3.org/2000/svg" fill="black" 
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                    class="size-3">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
                Favorites
            </button>

        
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
