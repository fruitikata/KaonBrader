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
            <!-- Button to Navigate to Profile -->
            <!--<div class="text-start">
                <a href="{{ route('profile.show', ['user' => auth()->user()->id]) }}" 
                   class="border rounded-full px-4 py-2 
                   {{ request()->is('profile*') ? 'bg-white text-black border-black' : 'bg-black text-white border-white' }}">
                   Favorites
                </a>
            </div>-->
            <button 
                onclick="window.location.href='{{ route('profile.show') }}'"
                class="flex items-center gap-1 px-3 h-8 rounded-full text-sm 
                       {{ $isFavoritesPage ? 'bg-white text-black border border-black' : 'bg-black text-white border border-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="white" 
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
        

        <div class="section-divider"></div>
    <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-5"> 
        @foreach ($favorites as $favorite) <!-- {{ $favorite->id }} -->
        <div id="click" onclick="location.href = '/recipes/{{ $favorite->recipe->id }}'" class="relative overflow-visible bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 flex flex-col items-start aspect-[1/1] w-full max-w-[280px] mx-auto relative">
        
            <!-- Display Image -->
            @if ($favorite->recipe->image)
                <img src="{{ asset('storage/' . $favorite->recipe->image) }}" 
                    alt="{{ $favorite->recipe->title }}" 
                    class="w-full h-40 object-cover rounded-md aspect-square mb-3">
            @else
                <div class="w-full h-40 bg-gray-300 rounded-md flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif
            
            <!-- Recipe Title -->
            <h2 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $favorite->recipe->title }}</h2>
            
            <!-- User and Date -->
            <div class="text-xs font-light text-gray-600 dark:text-gray-400">
                <span>Posted {{ $favorite->recipe->created_at->diffForHumans() }} by</span>
                <a href="#" class="text-blue-500 font-medium">{{ $favorite->recipe->user->name ?? 'Unknown' }}</a>
                <!--<a href="#" class="text-yellow-500 font-medium">
                    {{ optional($favorite->user)->name ?? 'Unknown' }}
                </a>-->
            </div>
        
            <!-- Favorite Button in Favorites Page -->
            <button id="favorite-btn-{{ $favorite->recipe->id }}" 
                onclick="event.stopPropagation(); toggleFavorite({{ $favorite->recipe->id }})"
                class="group relative flex items-center gap-1 px-3 py-1 text-sm font-medium rounded-full mt-2 border border-transparent
                {{ auth()->user()->favorites()->where('recipe_id', $favorite->recipe->id)->exists() ? 'text-black' : 'text-white' }}">
            
                <!-- Star Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ auth()->user()->favorites()->where('recipe_id', $favorite->recipe->id)->exists() ? 'black' : 'white' }}" 
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                </svg>
                <!-- Tooltip for Hover -->
                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 
                        text-xs text-white bg-black px-2 py-1 rounded opacity-0 
                        group-hover:opacity-100 transition-opacity pointer-events-none z-10 whitespace-nowrap">
                        {{ auth()->user()->favorites()->where('recipe_id', $favorite->recipe->id)->exists() ? 'Added to favorites' : 'Add to favorites' }}
                </span>
            
            </button>  
        </div>
        @endforeach
    </div>
</div>
    
<script>
    function toggleFavorite(recipeId) {
        let button = document.getElementById('favorite-btn-' + recipeId);
    
        fetch(`/favorites/toggle/${recipeId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                         class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M12 17.25l-5.45 3.03a.75.75 0 0 1-1.13-.79l1.04-5.73-4.17-4.06a.75.75 0 0 1 .41-1.28l5.78-.42 2.58-5.26a.75.75 0 0 1 1.35 0l2.58 5.26 5.78.42a.75.75 0 0 1 .41 1.28l-4.17 4.06 1.04 5.73a.75.75 0 0 1-1.13.79L12 17.25z"/>
                    </svg>
                `;
                button.classList.remove('text-gray-300', 'text-white');
                button.classList.add('text-black'); // When favorited, the star is black
            } else {
                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="black" 
                         class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M12 17.25l-5.45 3.03a.75.75 0 0 1-1.13-.79l1.04-5.73-4.17-4.06a.75.75 0 0 1 .41-1.28l5.78-.42 2.58-5.26a.75.75 0 0 1 1.35 0l2.58 5.26 5.78.42a.75.75 0 0 1 .41 1.28l-4.17 4.06 1.04 5.73a.75.75 0 0 1-1.13.79L12 17.25z"/>
                    </svg>
                `;
                button.classList.remove('text-black');
                button.classList.add('text-white'); // When not favorited, the star is white
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>




</x-app-layout>