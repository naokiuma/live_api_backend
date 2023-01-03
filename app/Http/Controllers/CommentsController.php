<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Comment_image;

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
        return response()->json($comments);

    }

    /**
     * 新しいコメントを作成
     */
    public function createComment(Request $request) {
        // Log::debug("debug creatのpost内容!");
        // Log::debug($request->all());

        $comment = new Comment();      
        // 保存したデータを$modelに格納
        $result = $comment->create([
            'topic_id' => $request->topic_id,
            'name' => $request->name,
            'text' => $request->text,
            'user_id' => $request->user_id,
        ]);

        //https://qiita.com/mashirou_yuguchi/items/14d3614173c114c30f02
        //画像があればテーブルに追加
        if(!is_null($request['file'])){
            $insert_id = $result->id;
            $image_path = $request->file('file')->store('public/comment/' . $insert_id . '/');

            Log::debug($image_path);


            $comment_imae = new Comment_image();
            $comment_imae->create([
                'comment_id' => $insert_id,
                'image_file_name' => $image_path,
            ]);
        }

        return response()->json(true);
    }

}