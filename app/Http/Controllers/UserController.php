<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\ProfilePicture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index(User $user){
        return Inertia::render('User', [
            'user' => $user,
            'followers_count' => $user->followers->count(),
            'followings_count' => $user->followings->count(),
            'is_following' => $user->followers()->where('user_id', auth()->id())->exists()
        ]);
    }

    public function follow(Request $request)
    {
        $user = User::find($request->id);

        $user->follow();

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function unfollow(Request $request)
    {
        $user = User::find($request->id);

        $user->unfollow();

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function storeProfilePic(Request $request){
        $request->validate([
            'avatar' => [
                'required',
                'file',
                'image'
            ]
        ]);

        $user = auth()->user();

        $photos_directory = "public/{$user->id}/photos";
        $small_photo_directory = "public/{$user->id}/120x120";
        
        if(!Storage::exists($photos_directory)){
            Storage::makeDirectory($photos_directory);
        }

        if(!Storage::exists($small_photo_directory)){
            Storage::makeDirectory($small_photo_directory);
        }

        $photos = $request->file('avatar');
        $extension = $photos->getClientOriginalExtension();
        $filename = Str::random(32) . '.' . $extension;
        
        $path = $photos->storeAs($photos_directory, $filename);
        
        Image::make($request->avatar)
            ->resize(120, 120)
            ->save(storage_path("app/{$small_photo_directory}/{$filename}"));

        $profile_pic = ProfilePicture::create([
            'user_id' => $user->id,
        ]);

        $photo = new Photo([
            'user_id' => $user->id,
            'url' => Storage::url($path)
        ]);

        $profile_pic->photo()->save($photo);

        return redirect()->back();
    }
}
