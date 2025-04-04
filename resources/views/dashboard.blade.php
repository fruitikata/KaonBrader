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
                
                {{-- Title --}}
                <h2 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $recipe->title }}</h2>
                
                {{-- User and Date --}}
                <div class="text-xs font-light text-gray-600 dark:text-gray-400">
                    <span>Posted {{ $recipe->created_at->diffForHumans() }} by</span>
                    <a href="#" onclick="event.stopPropagation();" class="text-blue-500 font-medium">
                        {{ $recipe->user->name ?? 'Unknown' }}
                    </a>
                </div>

                <button id="favorite-btn-{{ $recipe->id }}" 
                    onclick="event.stopPropagation(); toggleFavorite({{ $recipe->id }})"
                    class="px-3 py-1 text-sm font-medium rounded shadow-md mt-2
                    {{ auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists() ? 'bg-red-500 text-white' : 'bg-gray-300 text-black' }}">
                    {{ auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists() ? '❤️' : '🤍' }}
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
                    button.innerHTML = '❤️';
                    button.classList.remove('bg-gray-300', 'text-black');
                    button.classList.add('bg-red-500', 'text-white');
                } else {
                    button.innerHTML = '🤍';
                    button.classList.remove('bg-red-500', 'text-white');
                    button.classList.add('bg-gray-300', 'text-black');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    
    
</x-app-layout>
