<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [RecipeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');

Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');

Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

Route::resource('recipes', RecipeController::class); //update
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy'); //delete
//Route::get('/recipes/{recipe}', [RecipeController::class, 'edit'])->name('recipes.edit');
//Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');

//Route::patch('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');

Route::post('/favorites/toggle/{recipeId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('profile.show');  // This is for the profile page(recipes&favorites)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');  // This is for the edit profile page(account settings)
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/myfavorites', [FavoriteController::class, 'index'])->name('favorites.index');

require __DIR__.'/auth.php';