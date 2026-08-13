<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = ProductComment::with(['product', 'user'])->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(ProductComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
