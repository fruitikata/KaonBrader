<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserPostsController extends Controller
{
    public function userPosts(User $user)
    {
        $posts = $user->recipes()->latest()->get(); // Assuming recipes are the posts
        return view('userposts', compact('user', 'posts'));
    }
}
