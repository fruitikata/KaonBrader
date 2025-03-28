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
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 flex flex-col items-start aspect-[3/4] w-full max-w-[280px] mx-auto relative">
        
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
            <a href="#" class="text-blue-500 font-medium">{{ $recipe->user->name ?? 'Unknown' }}</a>
        </div>

        <!-- View Recipe Button (Positioned at Bottom Right) -->
        <a href="{{ route('recipes.show', $recipe->id) }}" 
            class="absolute bottom-2 right-2 px-3 py-1 mr-2 bg-yellow-500 hover:bg-yellow-600 text-black text-sm font-medium rounded shadow-md">
            View
        </a>
    </div>
@endforeach

        </div>
    </div>
    
    <div class="mt-6">
        {{ $recipes->links() }}
    </div>
    
</x-app-layout>
