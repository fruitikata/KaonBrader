<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe; 

class UserPostsController extends Controller
{
    public function index(User $user)
{
    $recipes = $user->recipes()->latest()->get();
    return view('userposts', compact('user', 'recipes')); // No folder prefix
}
}
