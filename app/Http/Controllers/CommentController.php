<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getList() {
        $comments = Comment::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Đóng góp ý kiến');
        $pageTitle = 'Đóng góp ý kiến';

        return view('admin.pages.comment.list',
            compact('headingTitle', 'pageTitle', 'comments')
        );
    }
}
