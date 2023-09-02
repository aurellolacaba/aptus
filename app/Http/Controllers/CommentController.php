<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\NewCommnentAdded;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class CommentController extends Controller
{
    public function store(Request $request, Post $post){
        $request->validate(['body' => 'required']);

        $comment = new Comment([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        $post->comments()->save($comment);
        
        if ($this->shouldNotifyTheAuthor($comment)) {
            $post->user->notify(new NewCommnentAdded($comment));
        }

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function toggleLike(Comment $comment) {
        $user = auth()->user();

        $comment->toggleLike($user);

        return redirect()->back();
    }

    private function shouldNotifyTheAuthor(Comment $comment)
    {
        $is_not_the_author = $comment->commentable->user_id !== auth()->id();
        $is_first_comment_by_user = $comment->commentable
            ->comments()
            ->where('user_id', auth()->id())
            ->pluck('user_id')
            ->count() == 1;

        return $is_not_the_author &&
            $is_first_comment_by_user;
    }
}
