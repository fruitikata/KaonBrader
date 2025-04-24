@php
    $isFavoritesPage = request()->is('favorites*');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pt-20">
            {{ __('Your saved recipes') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6" x-data="{ showEditModal: false, showDeleteModal: false, editingRecipe: null, deletingRecipe: null }">
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
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 font-bold truncate">{{ $recipe->title }}</p>
                            
                            <!--Edit button-->
                            <button 
                            @click="showEditModal = true; editingRecipe = Object.assign({ editing: false }, {{ $recipe->toJson() }})"
                            class="edit-button absolute mb-5 bottom-2 right-2 bg-white text-black p-2 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Preview Edit Modal -->
        <div
        x-show="showEditModal"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg w-full max-w-md relative shadow-xl overflow-y-auto max-h-[90vh]">
                <button @click="showEditModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">&times;</button>

                <!-- Preview Mode -->
                <template x-if="!editingRecipe.editing">
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">Recipe Details</h2>
                    
                        <p class="mb-2 text-black dark:text-white"><strong>Title:</strong> <span x-text="editingRecipe.title"></span></p>
                        <p class="mb-2 text-black dark:text-white"><strong>Description:</strong> <span x-text="editingRecipe.description"></span></p>
                        <p class="mb-2 text-black dark:text-white whitespace-pre-wrap"><strong>Ingredients:</strong><br> <span x-text="editingRecipe.ingredients"></span></p>
                        <p class="mb-2 text-black dark:text-white whitespace-pre-wrap"><strong>Steps:</strong><br> <span x-text="editingRecipe.steps"></span></p>
                    
                        <div class="flex justify-between mt-6">
                             <!-- Delete button on the far left -->
                             <div>
                                <button @click="showEditModal = false; showDeleteModal = true; deletingRecipe = editingRecipe"
                                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        
                            <!-- Edit button on the far right -->
                            <div>
                                <button @click="editingRecipe.editing = true"
                                    class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">
                                    Edit
                                </button>
                            </div>
                        </div>                        
                    </div>
                </template>
            
                <!-- Edit Form Mode -->
                <template x-if="editingRecipe.editing">
                    <form :action="'/recipes/' + editingRecipe.id" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        
                        <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">Edit Recipe</h2>
                        
                        <div class="mb-3">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Title</label>
                            <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded" :value="editingRecipe.title">
                        </div>
                    
                        <div class="mb-3">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Description</label>
                            <textarea name="description" rows="2" class="w-full border border-gray-300 p-2 rounded" x-text="editingRecipe.description"></textarea>
                        </div>
                    
                        <div class="mb-3">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Ingredients</label>
                            <textarea name="ingredients" rows="4" class="w-full border border-gray-300 p-2 rounded" x-text="editingRecipe.ingredients"></textarea>
                        </div>
                    
                        <div class="mb-3">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Steps</label>
                            <textarea name="steps" rows="5" class="w-full border border-gray-300 p-2 rounded" x-text="editingRecipe.steps"></textarea>
                        </div>
                    
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Replace Image</label>
                            <input type="file" name="image" class="w-full">
                        </div>
                    
                        <div class="flex justify-between mt-4">
                            <button @click.prevent="editingRecipe.editing = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Save</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div
            x-show="showDeleteModal"
            x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg w-full max-w-md relative shadow-xl text-center">
                <!-- Close button -->
                <button @click="showDeleteModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl">
                    &times;
                </button>
            
                <!-- Title -->
                <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">
                    Are you sure you want to delete
                    "<span x-text="deletingRecipe ? deletingRecipe.title : ''" class="font-semibold"></span>"?
                </h2>
            
                <!-- Message -->
                <p class="mb-6 text-black dark:text-white">
                    Once you delete a recipe, you can't undo it.
                </p>
            
                <!-- Centered Buttons -->
                <form :action="deletingRecipe ? '/recipes/' + deletingRecipe.id : ''" method="POST">
                    @csrf
                    @method('DELETE')
            
                    <div class="flex justify-center items-center gap-4">
                        <button 
                            @click.prevent="showDeleteModal = false" 
                            type="button" 
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 rounded hover:bg-gray-400 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
            
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    <style>
        /* Masonry Layout */
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
            columns: 2;
        }
    }
    </style>
</x-app-layout>