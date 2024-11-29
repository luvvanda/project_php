<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
// use App\Http\Controllers\ArticleController;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'desc' => 'required|max:250'
        ]);
        $comment = new Comment();
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->article_id = request('article_id');
        $comment->user_id = Auth::id();
        $comment->save();
        return redirect()->back();
    }
    //9-22 добавила 22.11

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        Gate::authorize('update_comment', $comment);
        return view('comment.update', ['comment' => $comment]);
        // compact('article')
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update_comment', $comment);
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);
        $comment->name = request('name');
        $comment->desc = request('desc');
        $comment->user_id = 1;
        $comment->save();
        return redirect()->route('article.show', ['article' => $comment->article_id]);
    }
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back();
    }



   

}