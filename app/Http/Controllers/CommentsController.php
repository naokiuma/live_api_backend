<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;


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

    /**
     * 新しいコメントを作成
     */
    public function createComment(Request $request) {
        Log::debug("debug creatのpost内容!");
        Log::debug($request->all());

        $comment = new Comment();      
        // 保存したデータを$modelに格納
        $comment->create([
            'topic_id' => $request->topic_id,
            // 'name' => $request->name,
            'text' => $request->text,
            'user_id' => $request->user_id,
        ]);

        return response()->json(true);
    }

}