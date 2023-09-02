<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Photo;
use App\Models\Post;
use App\Notifications\PostLiked;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $posts = $user->posts()
            ->withCount('comments')
            ->latest()
            ->get();

        return Inertia::render('Posts', compact('posts'));
    }

    public function store(StorePostRequest $request){
        $user_id = auth()->id();
        $photo = NULL;

        $post = Post::create([
            'user_id' => $user_id,
            'body' => $request->body
        ]);

        if($request->photos) {
            $photos_directory = "public/{$user_id}/photos";
            $small_photo_directory = "public/{$user_id}/20x20";
            
            if(!Storage::exists($photos_directory)){
                Storage::makeDirectory($photos_directory);
            }

            if(!Storage::exists($small_photo_directory)){
                Storage::makeDirectory($small_photo_directory);
            }

            $photos = $request->file('photos');
            $extension = $photos->getClientOriginalExtension();
            $filename = Str::random(32) . '.' . $extension;
            
            $path = $photos->storeAs($photos_directory, $filename);
            
            Image::make($request->photos)
                ->resize(20, 20)
                ->save(storage_path("app/{$small_photo_directory}/{$filename}"));

            $photo = new Photo([
                'user_id' => $user_id,
                'url' => Storage::url($path)
            ]);

            $post->photos()->save($photo);
        }

        return redirect()->route('home');
        
    }

    public function show(Post $post)
    {
        $post = $post->load(['user.profilePic.photo', 'photos', 'likes'])
            ->loadCount(['comments', 'likes']);
        
        $comments = $post->comments()
            ->with('user', 'replies.user')
            ->withCount(['likes', 'replies'])
            ->oldest()
            ->get();

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function toggleLike(Post $post){
        $user = auth()->user();

        $post->toggleLike($user);

        if($post->user->id != $user->id) {
            $post->user->notify(new PostLiked($post, $user));
        }

        return redirect()->back();
    }
}
