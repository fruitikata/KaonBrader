<x-app-layout>
    <x-slot name="header">
        <div class="pt-20">
            <!-- Back Button -->
            <a href="{{ url()->previous() }}"
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-200 text-gray-700 font-medium rounded-md shadow font-extrabold">
               &#8592; 
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-0.3 p-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow flex flex-col gap-6">
    
            <!-- Top Section: Image + Recipe + Comments side-by-side -->
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Image -->
                @if ($recipe->image)
                    <div class="w-full md:w-1/3">
                        <img src="{{ asset('storage/' . $recipe->image) }}"
                            alt="{{ $recipe->title }}"
                            class="w-full object-cover rounded-md">
                    </div>
                @endif
        
                <!-- Recipe Details -->
                <div class="flex-1 text-gray-700 dark:text-gray-300">
                    {{-- Favorite Button --}}
                    @php
                        $isFavorited = auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists();
                    @endphp
        
                    <button id="favorite-btn-{{ $recipe->id }}" 
                            onclick="event.stopPropagation(); toggleFavorite({{ $recipe->id }})"
                            class="group relative mt-0.5 mb-5 self-start">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             fill="{{ $isFavorited ? 'black' : 'white' }}" 
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-5 h-5 transition-colors duration-200">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                        </svg>
                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1 
                                    text-xs text-white bg-black px-2 py-1 rounded opacity-0 
                                    group-hover:opacity-100 transition-opacity pointer-events-none z-10 whitespace-nowrap">
                            {{ $isFavorited ? 'Added to favorites' : 'Add to favorites' }}
                        </span>
                    </button>
        
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $recipe->title }}
                    </h2>
                    {{-- <p class="text-sm mb-2">
                        Posted {{ $recipe->created_at->diffForHumans() }} by 
                        <a href="#" class="font-semibold">{{ $recipe->user->name ?? 'Unknown' }}</a>
                    </p> --}}
        
                    <p class="text-sm mb-2">
                        Posted {{ $recipe->created_at->diffForHumans() }} by 
                        <a href="{{ route('user.recipes', $recipe->user->id) }}" class="font-semibold">
                            {{ $recipe->user->name ?? 'Unknown' }}
                        </a>
                    </p>
                    
                    <h3 class="text-lg font-bold mt-2">Description</h3>
                    <p>{{ $recipe->description }}</p>
        
                    <h3 class="text-lg font-bold mt-4">Ingredients</h3>
                    <p>{{ $recipe->ingredients }}</p>
        
                    <h3 class="text-lg font-bold mt-4">Steps</h3>
                    <p>{{ $recipe->steps }}</p>
                </div>
        
                <!-- Comments on the side -->
                <div class="md:w-1/3 mt-4 md:mt-0 text-gray-700 dark:text-gray-300" x-data="{ showComments: false }">
                    <button
                        @click="showComments = !showComments"
                        class="text-lg font-semibold flex items-center gap-2"
                    >
                        <span>Comments</span>
                        <svg :class="{ 'rotate-180': showComments }" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                
                    <div x-show="showComments" x-transition class="mt-2">
                        @forelse($recipe->comments as $comment)
                            <div class="bg-gray-100 dark:bg-gray-800 p-3 my-2 rounded">
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong>{{ $comment->user->name }}</strong> • {{ $comment->created_at->diffForHumans() }}
                                </p>
                                <p class="text-gray-800 dark:text-gray-200">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
                        @endforelse
                    </div>
                </div>
                
            </div>
        
            <!-- Comment Form at the very bottom -->
            @if (Auth::check())
            <form method="POST" action="{{ route('comments.store') }}" class="mt-4" x-data="{ comment: '' }">
                @csrf
                <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            
                <!-- Comment Input Styled Like Messenger/YouTube -->
                <div class="flex items-center bg-gray-200 dark:bg-gray-700 rounded-full px-4 py-2">
                    <input
                        type="text"
                        name="body"
                        x-model="comment"
                        placeholder="Add a comment"
                        class="flex-grow bg-transparent border-none focus:outline-none text-sm text-gray-800 dark:text-gray-100"
                    />
                    
                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :class="comment.trim().length > 0 
                                ? 'text-white bg-yellow-500 hover:bg-yellow-600' 
                                : 'text-gray-400 bg-gray-300 cursor-not-allowed'"
                        :disabled="comment.trim().length === 0"
                        class="ml-2 px-3 py-1.5 rounded-full text-sm transition-colors duration-200"
                    >
                        Post
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
    <!-- Other Posts -->
        {{-- <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 max-w-5xl mx-auto mt-0.3 p-6">More Recipes</h3> --}}
    <div class="masonry [column-count:2] md:[column-count:3]  lg:[column-count:4] xl:[column-count:5] gap-4 mt-1 max-w-7xl mx-auto p-6">
        @foreach ($recipes as $other)
            @if ($other->id !== $recipe->id)
            <div class="break-inside-avoid mb-4">
                <a href="{{ route('recipes.show', $other->id) }}" class="block">
                    @if ($other->image)
                        <img src="{{ asset('storage/' . $other->image) }}"
                             alt="{{ $other->title }}"
                             class="w-full object-cover rounded-md transition-transform duration-200 hover:scale-105">
                    @endif
                </a>
            </div>
            @endif
        @endforeach
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

    <style>
        .masonry {
        columns: 4; /* Number of columns */
        column-gap: 16px; /* Space between columns */
        width: 100%;
    }

    [x-cloak] {
        display: none !important;
    }

    /* Individual Image Blocks */
    .recipe-item {
        display: inline-block;
        width: 100%;
        margin-bottom: 16px;
        break-inside: avoid;
    }

    /* Image Hover Effect */
    .recipe-image {
        transition: opacity 0.3s ease, transform 0.3s ease;
        object-fit: cover;
        border-radius: 8px;
    }
    /* Responsive Columns */
    @media (max-width: 1024px) {
        .masonry {
            columns: 3;
        }
    }

    @media (max-width: 768px) {
        .masonry {
            columns: 2;
        }
    }

    @media (max-width: 480px) {
        .masonry {
            columns: 2;
        }
    }
    </style>
</x-app-layout>
