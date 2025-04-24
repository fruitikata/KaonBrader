<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pt-20">
            {{ __('Upload a Recipe') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6">
            @csrf

            <!-- Image Upload -->
            <div class="md:w-1/3" x-data="{ imageUrl: null }">
                <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-700 border rounded flex items-center justify-center relative overflow-hidden mt-3">
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        @change="const file = $event.target.files[0];
                                 if (file) {
                                     imageUrl = URL.createObjectURL(file);
                                 }"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    />
                             
                    <!-- Image Preview or Text -->
                    <template x-if="imageUrl">
                        <img :src="imageUrl" alt="Selected Image" class="absolute inset-0 object-cover w-full h-full" />
                    </template>
                
                    <span x-show="!imageUrl" class="text-gray-500 dark:text-gray-300 z-0 text-sm text-center px-4">
                        Choose a file
                    </span>
                </div>
            </div>



            <!-- Recipe Info -->
            <div class="flex-1">
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

                <!-- Buttons -->
                <div class="flex justify-end gap-2">
                    <a href="{{ route('dashboard') }}" 
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md shadow">
                        Cancel
                    </a>

                    <button type="submit" 
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md shadow">
                        Upload Recipe
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
