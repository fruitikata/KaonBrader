<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your saved recipes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        <div class="flex justify-between mb-6">
            <!-- Button to Navigate to Profile -->
            <div class="text-start">
                <a href="{{ route('profile.show', ['user' => auth()->user()->id]) }}" 
                   class="border rounded-full px-4 py-2 
                   {{ request()->is('profile*') ? 'bg-white text-black border-black' : 'bg-black text-white border-white' }}">
                   Favorites
                </a>
            </div>
        
            <!-- User Info -->
            <div class="text-end">
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Joined {{ $user->created_at->format('F Y') }}</p>
            </div>
        </div>
        

        <div class="section-divider"></div>
    <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-4 gap-5"> 
        @foreach ($favorites as $favorite) <!-- {{ $favorite->id }} -->
        <div id="click" onclick="location.href = '/recipes/{{ $favorite->recipe->id }}'" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 flex flex-col items-start aspect-[1/1] w-full max-w-[280px] mx-auto relative">
        
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
        
            <!-- Favorite Button -->
            <button id="favorite-btn-{{ $favorite->recipe->id }}" 
                onclick="event.stopPropagation(); toggleFavorite({{ $favorite->recipe->id }})"
                class="px-3 py-1 text-sm font-medium rounded shadow-md mt-2
                {{ auth()->user()->favorites()->where('recipe_id', $favorite->recipe->id)->exists() ? 'bg-red-500 text-white' : 'bg-gray-300 text-black' }}">
                {{ auth()->user()->favorites()->where('recipe_id', $favorite->recipe->id)->exists() ? '❤️' : '🤍' }}
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