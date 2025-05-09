@php
    $isFavoritesPage = request()->is('favorites*');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pt-20">
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
                       {{ $isFavoritesPage 
                            ? 'bg-white text-black border border-black dark:bg-white dark:text-black' 
                            : 'bg-black text-white border border-white dark:bg-black dark:text-white' }}">
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
        <div class="masonry max-w-7xl mx-auto px-6 lg:px-5 mt-6">
            <div class="columns-2 sm:columns-3 lg:columns-4 gap-5 space-y-5">
                @foreach ($favorites as $favorite)
                    @if ($favorite->recipe && $favorite->recipe->image)
                        <div class="break-inside-avoid">
                            <!-- Link to Recipe -->
                            <a href="{{ route('recipes.show', $favorite->recipe->id) }}" class="block">
                                <img src="{{ asset('storage/' . $favorite->recipe->image) }}"
                                     alt="{{ $favorite->recipe->title }}"
                                     class="w-full object-cover rounded-md transition-transform duration-200 hover:scale-105">
                            </a>
        
                            <div class="flex justify-between items-center mt-2">
                                <!-- Title -->
                                <p class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                    {{ $favorite->recipe->title }}
                                </p>
                        
                                <!-- Favorite Icon -->
                                <button id="favorite-btn-{{ $favorite->recipe->id }}" 
                                        onclick="event.stopPropagation(); toggleFavorite({{ $favorite->recipe->id }})"
                                        class="group relative p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         fill="black" 
                                         viewBox="0 0 24 24" 
                                         stroke-width="1.5" 
                                         stroke="currentColor" 
                                         class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                              d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 
                                                 text-xs text-white bg-black px-2 py-1 rounded opacity-0 
                                                 group-hover:opacity-100 transition-opacity pointer-events-none z-10 whitespace-nowrap">
                                        Added to favorites
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
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