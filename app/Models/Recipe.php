<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\RecipeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'ingredients',
        'steps',
        'image',
        'category_id',  
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
       return $this->belongsToMany(User::class, 'favorites', 'recipe_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
