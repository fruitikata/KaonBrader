<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Recipe') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Image Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium">Recipe Image (Optional)</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium">Title</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border rounded">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium">Description</label>
                <textarea name="description" required class="w-full px-3 py-2 border rounded"></textarea>
            </div>

            <!-- Ingredients -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium">Ingredients</label>
                <textarea name="ingredients" required class="w-full px-3 py-2 border rounded"></textarea>
            </div>

            <!-- Steps -->
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-200 font-medium">Steps</label>
                <textarea name="steps" required class="w-full px-3 py-2 border rounded"></textarea>
            </div>

            <!-- Upload Buttons -->
            <div class="flex justify-end gap-2">
                <!-- Cancel Button -->
                <a href="{{ route('dashboard') }}" 
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md shadow">
                    Cancel
                </a>
            
                <!-- Upload Recipe Button -->
                <button type="submit" 
                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow">
                    Upload Recipe
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
