<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function Search(Request $request) {
            // $game = Topic::where('game_title', $game_name)->get();    
            $search_word = $request->query('game'); 
            Log::debug("ゲームを探す");
            Log::debug($search_word);

            // todo search_wordがない場合のifを追加
            $games = Game::where('game_name', 'LIKE', '%'.$this->escape_like($search_word).'%');
            $games = $games->get();
            // $users = User::where('name', 'LIKE', '%'.$keyword.'%');
            // $users = User::where("name", "LIKE", "Bob%");  
            // ->leftJoin('topics', 'games.id', '=', 'topics.game_id')
            // ->get();


            if(count($games) == 0){
                Log::debug("ゲームは見つからず");
                return 'ゲームが見つかりませんでした';
            }else{
                foreach($games as $_game){
                    // Log::debug('ループの情報');
                    $target = $_game->id;//一旦変数に詰め込む必要がある
                    $temp = DB::table('topics')
                        ->select('*')
                        ->where('topics.game_id',$target)
                        ->get();
                    
                    $_game['topics'] = [];
                    $_game['topics']  = $temp;
                    
                }
            }


              

            Log::debug($games);


        


       
            return response()->json($games);
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



