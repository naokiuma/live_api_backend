<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsController extends Controller
{



    public function getTopics($topic_id = null) {
        if(isset($topic_id)){
            $topics = Topic::where('id', $topic_id)->get();
        }else{
            $topics = Topic::get();
        }

        return response()->json($topics);

    }

    public function getTopicsWithComments($topic_id) {
        $topics = Topic::Join('comments', 'topics.id', '=', 'comments.topic_id')
        
            ->where('id', $topic_id)
            ->get();

        return response()->json($topics);
    }

    /**
     * 新しいトピックを投稿
     */
    public function createTopics(Request $request) {

    //     $topic = new Topic();
        
    //     // 保存したデータを$modelに格納
    //     $model = $topic->create([
    //         'title' => 'testname',
    //         'body' => 'mail@test.com',
    //         'status' => 'プレイ中',
    //     ]);

    //    dd($model->title); // "testname"
       dd('到達した');
    }




}