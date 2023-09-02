<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $posts = Post::userNewsfeed($user)
            ->with(['user.profilePic.photo', 'photos', 'likes'])
            ->withCount('comments', 'likes')
            ->latest('updated_at')
            ->paginate(3);

        return Inertia::render('Home', compact('posts'));
    }
}
