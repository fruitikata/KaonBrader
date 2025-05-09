    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\RecipeController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\FavoriteController;
    use App\Http\Controllers\UserPostsController;
    use App\Http\Controllers\CommentController;
    use App\Http\Controllers\GoogleController;
    use App\Models\Recipe;


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

    // Route::middleware(['auth'])->group(function () {
    //     Define the route for showing user recipes
    //     Route::get('/user/{user}/recipes', [UserController::class, 'showRecipes'])->name('user.recipes');
    // });

    // Route::get('/userposts', [UserPostsController::class, 'userPosts'])->name('posts.user');
    // Route::get('/user/{user}/recipes', [UserPostsController::class, 'recipes'])->name('user.recipes');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/user/{user}/recipes', [UserPostsController::class, 'index'])
    ->name('user.recipes');
    require __DIR__.'/auth.php';

    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    Route::get('/dashboard', function () {
        $recipes = Recipe::latest()->get();
        return view('dashboard', compact('recipes'));
    })->middleware(['auth', 'verified'])->name('dashboard');