<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Log;

class TopicsController extends Controller
{

    public function getTopics($topic_id = null) {
        if(isset($topic_id)){
            $topics = Topic::where('id', $topic_id)->get();            
        }else{
            $topics = Topic::leftJoin('games','games.id', '=', 'topics.game_id')
            ->limit(9)
            ->get([
                'topics.id','topics.parent_user_id','topics.game_id','topics.title','topics.body','topics.status','topics.image_path',
                'games.game_name','games.genres','games.hard'
            ]);
            // DB::enableQueryLog();//中身を確認開始
        }


        //タグを追加
        foreach($topics as $topic){
            // Log::debug('ループの情報');
            $target = $topic->id;//一旦変数に詰め込む必要がある
            $temp = DB::table('topic_categories')
                ->select('name','color')
                ->leftJoin('categories', 'categories_id', '=', 'categories.category_id')
                ->where('topic_categories.topics_id',$target)
                ->get();

            $topic['tags'] = [];
            $topic['tags'] = $temp;
        }
        // dd(DB::getQueryLog());//中身を確認

        return response()->json($topics);
    }


    /*コメントと共に取得*/
    public function getTopicsWithComments($topic_id) {
        $topics = Topic::Join('comments', 'topics.id', '=', 'comments.topic_id')
            ->where('id', $topic_id)
            ->get();
        return response()->json($topics);
    }


    /**
     * 新しいトピックを投稿
     */
    public function create(Request $request) {
        Log::debug("debug post内容!");
        Log::debug($request->all());
        $topic = new Topic();
        $result = $topic->create([
            'game_id' => $request->game_id,
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
        ]);
        
        //https://qiita.com/mashirou_yuguchi/items/14d3614173c114c30f02
        //画像があればテーブルに追加
        if(!is_null($request['file'])){
            $insert_id = $result->id;
            $image_path = $request->file('file')->store('public/topics/' . $insert_id . '/');
            Topic::where('id', $insert_id)
                ->update(['image_path' => $image_path]);
        }

        Log::debug($result);



        return response()->json($result);
    }

    /**
     * 新しいトピックを投稿
     */
    public function edit(Request $request) {
        
        
       
    }

}