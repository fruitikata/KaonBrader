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

        <h3 class="text-lg font-bold mt-4 section-divider">My Recipes</h3>
        
        <!-- Masonry Layout Container -->
        <div class="masonry">
            @foreach ($recipes as $recipe)
                <div class="recipe-item relative">
                    @if ($recipe->image)
        <div class="recipe-image-wrapper">
            <a href="{{ route('recipes.show', $recipe->id) }}" class="block">
                <img src="{{ asset('storage/' . $recipe->image) }}" 
                     alt="{{ $recipe->title }}" 
                     class="recipe-image w-full h-auto rounded-md transition-all duration-300 ease-in-out cursor-pointer">
            </a>
            
            <!-- Edit Icon Button -->
            <button class="edit-button absolute bottom-2 right-2 bg-white text-black p-2 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                  </svg>

            </button>

        </div>
            @endif
                </div>
            @endforeach
        </div>
    </div>

<style>
    /* Masonry Layout */
.masonry {
    columns: 4; /* Number of columns */
    column-gap: 16px; /* Space between columns */
    width: 100%;
}

/* Individual Image Blocks */
.recipe-item {
    display: inline-block;
    width: 100%;
    margin-bottom: 16px;
    break-inside: avoid; /* Prevents images from breaking across columns */
}

/* Image Hover Effect */
.recipe-image {
    transition: opacity 0.3s ease, transform 0.3s ease;
    object-fit: cover;
    border-radius: 8px;
}

.recipe-image:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.edit-button {
    opacity: 0;
    position: absolute;
    bottom: 10px;
    right: 10px;
    transition: opacity 0.3s ease;
}


.recipe-item:hover .edit-button {
    opacity: 1;
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
        columns: 1;
    }
}

</style>
</x-app-layout>
