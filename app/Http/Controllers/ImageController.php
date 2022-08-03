<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //ビュー
    public function input()
    {
        return view('images.input');
    }

    public function upload(Request $request)
    {
        

        //validation
        $validated = $request->validate([
            'file' => 'required|file|image|mimes:jpg,bmp,png|', //配列でもかける。
        ]);

        logger('validation結果');
        logger($validated);

        logger('アップファイル');
        logger($request->file('file'));

        if ($request->file('file')->isValid([])) {
            Storage::disk('s3')->putFile('/test', $request->file('file'), 'public');
            return redirect('/');
        }else{
            return redirect('/');
        }
    }


}
