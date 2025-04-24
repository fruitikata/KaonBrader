<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Recipe;

class Comment extends Model
{
    protected $fillable = ['user_id', 'recipe_id', 'body'];
    
    public function user()
    {
            return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
