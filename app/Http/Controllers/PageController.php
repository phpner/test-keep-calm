<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function getPage(int $id)
    {
        $page = Page::where('status', Page::STATUS['open'])
            ->withCount(['comments' => function ($query) {
                $query->where('status', Comment::STATUS['open']);
            }])
            ->with(['comments.user', 'comments'=> function ($query) {
                $query->where('status', Comment::STATUS['open'])
                    ->orderByDesc('id')
                    ->take(Comment::DEFAULT_COUNT);
            }])
            ->findOrFail($id);

        $page['preComment'] = Comment::DEFAULT_COUNT;

        return view('page', ['page' => $page]);
    }
}
