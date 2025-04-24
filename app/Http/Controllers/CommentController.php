<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'body' => 'required|string',
        'recipe_id' => 'required|exists:recipes,id'
    ]);

    Comment::create([
        'user_id' => auth()->id(),
        'recipe_id' => $request->recipe_id,
        'body' => $request->body,
    ]);

    return back();
}

}
