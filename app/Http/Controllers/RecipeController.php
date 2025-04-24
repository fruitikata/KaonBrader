<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $recipes = Recipe::latest()->paginate(12);
        // $recipes = Recipe::latest()->get();

        $search = $request->input('search');

    if ($search) {
        $recipes = Recipe::where('title', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%")
                         ->latest()
                         ->get();

        return view('search', [ 'recipes' => $recipes, 'search' => $search ]);
    }

    $recipes = Recipe::latest()->get();
        return view('dashboard', [ 'recipes' => $recipes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('recipe_images', 'public');
        }

        // Assign authenticated user ID
        $validatedData['user_id'] = auth()->id();

        Recipe::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Recipe uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        // return view('show', compact('recipe'));

        // return view('show', ['recipe' => $recipe]);
        // return view('show', compact('recipe', 'recipes'));

        // $recipes = Recipe::latest()->paginate(12); 
        // return view('show', [
        // 'recipe' => $recipe,
        // 'recipes' => $recipes
            $recipes = Recipe::where('id', '!=', $recipe->id)->latest()->get();
                    
            return view('show', [
            'recipe' => $recipe,
            'recipes' => $recipes,
        ]);
    }

    public function markBackClicked()
{
    session(['back_clicked' => true]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', [ 'post' => $recipe]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('recipe_images', 'public');
        }

        // update
        $recipe->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Recipe updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        // Delete the image file from storage if it exists
    if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
        Storage::disk('public')->delete($recipe->image);
    }

    // Delete the recipe from the database
    $recipe->delete();

    return redirect()->route('dashboard')->with('success', 'Recipe deleted successfully!');
    }
}
