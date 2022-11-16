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
            $topics = Topic::get();
        }

        Log::debug("debug ログ!");
        Log::debug($topics);


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



        Log::debug("debug post内容!");
        Log::debug($request->all());

        // Log::debug($request->file());
        // Log::debug("debug post内容2!");

        // Log::debug($request->all());
        // $file = $_FILES['file'];
        // Log::debug(        );



        


        // // request()->all()
        // $item_image_path = $request->file();
        // $file = $request->file('file_name');
        // $file = $request->file_name;

        // Log::debug('イメージパスです');
        // Log::debug($item_image_path);

        // if ($request->hasFile('file')) {
            
        // }

        





        $topic = new Topic();
        // $path = Storage::disk("public")->putFile('file', $image);
        // $imagePath = "/storage/$path";

        $image_path = $request->file('file')->store('public/avatar/');
        Log::debug('画像です');

        Log::debug($image_path);


            // 保存したデータを$modelに格納
            // $topic->create([
            //     'title' => $request->title,
            //     'body' => $request->body,
            //     'status' => $request->status,
            // ]);

        //    dd($model->title); // "testname"
        //    dd('到達した');
        //    return true;
        // dump('到達');
        return response()->json(
            true
        );
        
    }




}