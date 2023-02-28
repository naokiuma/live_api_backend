<?php

namespace App\Http\Controllers;

// ジャンル
use DB;
use App\Models\Genre;
use Illuminate\Support\Facades\Log;

class GenresController extends Controller
{

    public function getGenres() {        
       
            $genres = Genre::get();
            // DB::enableQueryLog();//中身を確認開始
            // dd(DB::getQueryLog());//中身を確認
            Log::debug("debug category");
            Log::debug($genres);
        return response()->json($genres);

    }

}