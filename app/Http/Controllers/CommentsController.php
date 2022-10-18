<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function getComments($topic_id = null) {
        // logic to get all students goes here
        if(isset($topic_id)){
            $comments = Comment::where('topic_id', $topic_id)->get();
        }else{
            $comments = Comment::get();
        }
        // DB::enableQueryLog();
        // $comments = Comment::where('topic_id', $topic_id)->get();
        // dd(DB::getQueryLog());
        return response()->json($comments);
        //return response($comments, 200);

    }

}