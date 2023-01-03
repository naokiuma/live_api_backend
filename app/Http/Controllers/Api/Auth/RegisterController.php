<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller {
    public function register(RegisterRequest $request) {
        // Log::debug("debug registerでののpost内容!");
        // Log::debug($request->all());

        User::create([
            'name' =>  $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['created' => true], Response::HTTP_OK);
    }
}