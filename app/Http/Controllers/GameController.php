<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Game_image;
use App\Models\Category;

use Illuminate\Support\Facades\Log;


/**
 * 単語から検索関数
 */
class GameController extends Controller
{
    public function Search(Request $request) {
            if(null === $request->input('game')){
                $games = Game::inRandomOrder()->take(3)->get();

                // return response()->json([]);//もしゲームがない場合は全部出してもいいかも？
            }else{   
                $search_word = $request->input('game');
                Log::debug($search_word);
                
                // $games = Game::select('games.*','game_images.*')
                //     ->where('game_name', 'LIKE', '%'.$this->escape_like($search_word).'%')
                //     ->leftJoin('game_images', 'games.id', '=', 'game_images.game_id')
                //     ->get();
                
                $games = Game::where('game_name', 'LIKE', '%'.$this->escape_like($search_word).'%')->get();
            }

            foreach($games as $_each_game){
                // Log::debug('ループの情報');
                $target_id = $_each_game->id;//一旦変数に詰め込む必要がある
                $temp = DB::table('game_images')
                    ->select('*')
                    ->where('game_images.game_id',$target_id)
                    ->get();
    
                // $_each_game['images'] = [];
                $_each_game['images'] = $temp;
            }


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

    /**
     * 新しいゲームを登録
     */
    public function create(Request $request) {
        Log::debug("debug post内容!");
        $data = $request->all();
        Log::debug($request->all());


        
        $game = new Game();
        $result = $game->create([
            'game_name' => $request->game_name,
            'genres' => $request->genres,
            'hard' => 'Nintendo Switch',
        ]);






        //https://qiita.com/mashirou_yuguchi/items/14d3614173c114c30f02
        //画像があればテーブルに追加
        $insert_id = $result->id;
        // $categories = [];
        // $imgs = [];

        foreach($data as $key => $_val){
            if(strpos( $key, 'category' ) !== false){
                //カテゴリーを追加
                // $categories[] = $_val;
                // Log::debug($categories);
            }else if(strpos( $key, 'file' ) !== false){
                //画像を追加
                // $imgs[] = $_val;
                // Log::debug($imgs);
                $image_path = $_val->store('public/game/' . $insert_id . '/');
                Log::debug($image_path);

                $gameImage = new Game_image();
                $game_img_result = $gameImage->create([
                    'game_id' => $insert_id,
                    'image_file_name' => $image_path
                ]);
            }
        }


        return response()->json($result);
    }


    /**
     * 
     */
    public function getGame($game_id = null) {
        // if(isset($game_id)){
        $game = Game::where('id', $game_id)->get();            
        // }

        //todo カテゴリーを追加
        //todo 画像ーを追加

       
        return response()->json($game);
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



