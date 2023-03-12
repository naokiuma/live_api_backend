<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Game_image;

use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function Search(Request $request) {
            if(null === $request->input('game')){
                return response()->json([]);
            }
            
            $search_word = $request->input('game');
            Log::debug($search_word);
            $games = Game::where('game_name', 'LIKE', '%'.$this->escape_like($search_word).'%');
            $games = $games->get();


            if(count($games) == 0){
                return response()->json([]);
            }else{
                foreach($games as $_game){
                    $target = $_game->id;//一旦変数に詰め込む必要がある
                    $temp = DB::table('topics')
                        ->select('*')
                        ->where('topics.game_id',$target)
                        ->get();

                    $_game['topics']  = $temp;
                }
                Log::debug($games);
                return response()->json($games);
            }
            
    }

    // /**
    //  * 新しいゲームを登録
    //  */
    public function create(Request $request) {
        Log::debug("debug post内容!");
        Log::debug($request->all());
        $game = new Game();
        $result = $game->create([
            'game_name' => $request->title,
            'genres' => $request->body,
            'status' => $request->status,
        ]);
        
        //https://qiita.com/mashirou_yuguchi/items/14d3614173c114c30f02
        //画像があればテーブルに追加
        if(!is_null($request['file'])){
            $insert_id = $result->id;
            $image_path = $request->file('file')->store('public/game/' . $insert_id . '/');

            $gameImage = new Game_image();
            $game_result = $gameImage->create([
                'game_id' => $insert_id,
                'image_file_name' => $image_path
            ]);
        }

        return response()->json($result);
    }



    function escape_like(string $value, string $char = '\\')
    {
        return str_replace(
                [$char, '%', '_'],
                [$char.$char, $char.'%', $char.'_'],
                $value
        );
    }

}



