<!-- resources/views/user/userposts.blade.php -->
{{-- <x-layout>
    
    <h2>{{ $user->name }}'s Recipes</h2>
    
    @if($recipes->isEmpty())
        <p>This user has no recipes yet.</p>
    @else
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    <a href="{{ route('recipe.show', $recipe) }}">{{ $recipe->title }}</a> <!-- Link to individual recipe -->
                    <p>{{ $recipe->created_at->diffForHumans() }}</p>
                </li>
            @endforeach
        </ul>
    @endif 

</x-layout> --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recipes by {{ $user->name }}</h1>
        
        @foreach($recipes as $post)
            <div class="post">
                <!-- Display each post/recipe here -->
                <h2>{{ $recipe->title }}</h2>
                <p>{{ $recipe->description }}</p>
            </div>
        @endforeach
    </div>
@endsection