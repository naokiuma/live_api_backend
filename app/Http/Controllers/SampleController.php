<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SampleController extends Controller
{
    public function index($id = 1,Request $request,Response $response){
        return <<<EOF
        <html>
            <head>
                <title>
                    hero/index
                </title>
            </head>
            <body>
                {$id}
                これはテストです。

                <h3>リクエスト情報</h3>
                <p>
                {$request}
                </p>

                <h3>レスポンス情報</h3>
                <p>
                {$response}
                </p>
            </body>
        </html>
        EOF;
        
           
    }
}

?>


