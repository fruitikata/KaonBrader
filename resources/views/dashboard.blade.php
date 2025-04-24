<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pt-20">
            {{ __('LATEST RECIPE POSTS') }}
        </h2>
        
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        <div class="columns-2 sm:columns-3 lg:columns-4 gap-5 space-y-5"> 
            @foreach ($recipes as $recipe)
                @if ($recipe->image)
                    <div class="break-inside-avoid">
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="block">
                            <img src="{{ asset('storage/' . $recipe->image) }}" 
                                 alt="{{ $recipe->title }}" 
                                 class="w-full object-cover rounded-md transition-transform duration-200 hover:scale-105">
                        </a>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 font-bold truncate">{{ $recipe->title }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    
    
    {{-- <div class="mt-6">
        {{ $recipes->links() }}
    </div> --}}
    

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
