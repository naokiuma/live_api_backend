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

}