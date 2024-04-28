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
			Log::debug("debug クエリかいし");
			// クエリログを有効にする
			DB::enableQueryLog();

            if($request->input('game') === null){
				//ランダムで3件取得
                $games = Game::orderByDesc('id')->get();
                // return response()->json([]);//もしゲームがない場合は全部出してもいいかも？
            }else{   
                $search_word = $request->input('game');
                Log::debug($search_word);   
                $games = Game::where('game_name', 'LIKE', '%'.$this->escape_like($search_word).'%')->get();
            }
			Log::debug("debug クエリ完了");
			 // クエリログを取得して出力する
			$queries = DB::getQueryLog();
			Log::debug("クエリログ", $queries);

            foreach($games as $_each_game){
                // Log::debug('ループの情報');
                // $target_id = $_each_game->id;//一旦変数に詰め込む必要がある
                $temp = DB::table('game_images')
                    ->select('*')
                    ->where('game_images.game_id',$_each_game->id)
                    ->get();
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
                        ->limit(3)
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
		Log::debug('insert_idです');
		Log::debug($insert_id);
		
        // $categories = [];

        foreach($data as $key => $_val){
            if(strpos( $key, 'category' ) !== false){
                //カテゴリーを追加
                // $categories[] = $_val;
                // Log::debug($categories);
            }else if(strpos( $key, 'file' ) !== false){
                //画像を追加
                $image_path = $_val->store('public/game/' . $insert_id);
                Log::debug('img_pathです');
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
	 * 改修中
	 */
	public function getGame2(Request $request) {
        $data = $request->all();
        Log::debug($request->all());



        // if($game_id){

        //     Log::debug("debug getGame");
        //     Log::debug($game_id);

        //     $game = Game::where('id', $game_id)->get();  
        //     Log::debug($game);

        //     $temp = DB::table('game_images')
        //         ->select('*')
        //         ->where('game_images.game_id',$game_id)
        //         ->get();
        //     $game['images'] = $temp;
			
        //     return response()->json($game);
        // }else{
   
        //     $games = Game::inRandomOrder()->take(5)->get();
        //     Log::debug("debug getGameのデータ2");
        //     Log::debug($games);

		// 	//todo foreachで回せばどっちのルートでも同じでは？
        //     foreach($games as $_game){
        //         $target_id = $_game->id;
        //         $temp = DB::table('game_images')
        //         ->select('*')
        //         ->where('game_images.game_id',$target_id)
        //         ->get();

        //         $_game['images']  = $temp;
        //     }
            
        //     return response()->json($games);
            
        // }

        //todo カテゴリーを追加
        //todo 画像ーを追加       
    }

    /**
     * 各ゲームを取得
	 * idを指定しない場合はランダムで取得
     */
    public function getGame($game_id = null) {
        if($game_id){

            Log::debug("debug getGame");
            Log::debug($game_id);

            $result = Game::where('id', $game_id)->get();  
            Log::debug($result);

            $temp = DB::table('game_images')
                ->select('*')
                ->where('game_images.game_id',$game_id)
                ->get();
            $result['images'] = $temp;
			
            return response()->json($result);
        }else{
   
            $result = Game::inRandomOrder()->take(5)->get();
            Log::debug("debug getGameのデータ2");
            Log::debug($result);

            foreach($result as $key => $val){
                $target_id = $val->id;
                $temp = DB::table('game_images')
                ->select('*')
                ->where('game_images.game_id',$target_id)
                ->get();

                $result[$key]['images']  = $temp;
            }
            
            return response()->json($result);
            
        }

        //todo カテゴリーを追加
        //todo 画像ーを追加       
    }


	/**
	 * ゲームデータとtopicを取得
	 * 詳細ページ用
	 */
	function getGame_with_topic($game_id){

		$result = Game::where('id', $game_id)->get(); 

		$temp = DB::table('topics')
			->select('*')
			->where('topics.game_id',$game_id)
			->orderBy('created_at', 'desc')
			->limit(5)
			->get();
		$result[0]['topics'] = $temp;

		$temp = DB::table('game_images')
			->select('*')
			->where('game_images.game_id',$game_id)
			->get();
		$result[0]['images'] = $temp;
		
        

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



