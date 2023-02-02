<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    public function getCategories() {        
       
            $category = Category::get();
            // DB::enableQueryLog();//中身を確認開始
            // dd(DB::getQueryLog());//中身を確認
            Log::debug("debug category");
            Log::debug($category);
        return response()->json($category);

    }

}