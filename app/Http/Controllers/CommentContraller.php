<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentContraller extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function CommentsLoadMore(Request $request): array
    {
        $validated = $request->validate([
            'postId' => 'required|integer',
            'commentsPre' => 'required|integer',
            'commentsCurrentList' => 'required|integer',
        ]);

        $offset = $validated['commentsPre'] * $validated['commentsCurrentList'];

        $returnComment['comments'] = Comment::with('user')
            ->where('page_id', $validated['postId'])
            ->where('status', Comment::STATUS['open'])
            ->orderByDesc('id')
            ->skip($offset)
            ->take($validated['commentsPre'])
            ->get()
            ->toArray();

        $returnComment['commentsCurrentList'] = ++$validated['commentsCurrentList'];

        return $returnComment;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function CommentsAdd(Request $request): array
    {
        $validated = $request->validate([
            'postId' => 'required|integer',
            'userId' => 'required|integer',
            'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->text = $validated['comment'];
        $comment->page_id = $validated['postId'];
        $comment->user_id = $validated['userId'];
        $comment->status = Comment::STATUS['open'];
        $comment->save();

        $comment['user'] = Auth::user();
        return $comment->toArray();
    }
}
