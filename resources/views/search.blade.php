<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight pt-20">
            Search results for: <span class="text-yellow-500">"{{ $search }}"</span>
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 lg:px-5 mt-6">
        @if ($recipes->isEmpty())
            <p class="text-center text-gray-500">No recipes found.</p>
        @else
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
        @endif
    </div>

</x-app-layout>
