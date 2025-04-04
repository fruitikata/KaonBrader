<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        // Fetch favorites with the associated recipe -- favorites
        $favorites = $user->favorites()->with('recipe')->get();
        return view('myfavorites', compact('favorites', 'user'));
    }


    public function toggle($recipeId)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
                            ->where('recipe_id', $recipeId)
                            ->first();
        
        if ($favorite) {
            // If the recipe is already favorited, remove it
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // If not, add it to the favorites
            Favorite::create([
                'user_id' => $user->id,
                'recipe_id' => $recipeId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
