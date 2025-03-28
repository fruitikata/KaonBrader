<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $recipe->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <!-- Recipe Image -->
        @if ($recipe->image)
            <img src="{{ asset('storage/' . $recipe->image) }}" 
                alt="{{ $recipe->title }}" 
                class="w-full aspect-square object-cover rounded-md mb-3">
        @endif


        <!-- Recipe Details -->
        <div class="text-gray-700 dark:text-gray-300">
            <p class="text-sm mb-2">Posted {{ $recipe->created_at->diffForHumans() }} by 
                <span class="font-semibold">{{ $recipe->user->name ?? 'Unknown' }}</span>
            </p>

            <h3 class="text-lg font-bold mt-4">Description</h3>
            <p>{{ $recipe->description }}</p>

            <h3 class="text-lg font-bold mt-4">Ingredients</h3>
            <p>{{ $recipe->ingredients }}</p>

            <h3 class="text-lg font-bold mt-4">Steps</h3>
            <p>{{ $recipe->steps }}</p>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-md shadow">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>