<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request){
        $request->validate([
            'q' => 'required'
        ]);

        $results = User::where('first_name', 'LIKE', "%{$request->q}%")
            ->orWhere('last_name', 'LIKE', "%{$request->q}%")
            ->orWhere('email', 'LIKE', "%{$request->q}%")
            ->withCount('followings', 'followers')
            ->paginate(5);

        return Inertia::render('Search', [
            'results' => $results
        ]);
    }
}
