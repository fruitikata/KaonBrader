<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('LATEST RECIPE POSTS') }}
        </h2>
        
    </x-slot>

    <!--<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-6 text-gray-900 dark:text-gray-100">
                    {{ __(".") }}
                </div>
            </div>
        </div>
    </div>-->
    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-5"> 
            @foreach ($recipes as $recipe)
            <div id="click" onclick="location.href = '/recipes/{{ $recipe->id }}'" class="relative overflow-visible bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 flex flex-col items-start aspect-[1/1] w-full max-w-[280px] mx-auto relative">

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
                
                {{-- Title --}}
                <h2 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $recipe->title }}</h2>
                
                {{-- User and Date --}}
                <div class="text-xs font-light text-gray-600 dark:text-gray-400">
                    <span>Posted {{ $recipe->created_at->diffForHumans() }} by</span>
                    <a href="#" onclick="event.stopPropagation();" class="text-blue-500 font-medium">
                        {{ $recipe->user->name ?? 'Unknown' }}
                    </a>
                </div>

                @php
                    $isFavorited = auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists();
                @endphp

                <button id="favorite-btn-{{ $recipe->id }}" 
                    onclick="event.stopPropagation(); toggleFavorite({{ $recipe->id }})"
                    class="group relative p-2">
                    
                    <!-- Star SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         fill="{{ $isFavorited ? 'black' : 'white' }}" 
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                         class="w-5 h-5 transition-colors duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                
                    <!-- Tooltip -->
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 
                                 text-xs text-white bg-black px-2 py-1 rounded opacity-0 
                                 group-hover:opacity-100 transition-opacity pointer-events-none z-10 whitespace-nowrap">
                        {{ $isFavorited ? 'Added to favorites' : 'Add to favorites' }}
                    </span>
                </button>
               
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="mt-6">
        {{ $recipes->links() }}
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
