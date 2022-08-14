<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function getAllComments() {
        // logic to get all students goes here
        $comments = Comment::get();
        return response()->json($comments);
        //return response($comments, 200);

    }
}