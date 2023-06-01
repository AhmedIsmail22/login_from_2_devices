<?php

namespace App\Repositories;

use App\RepositoryInterfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DBUserRepository implements UserRepositoryInterface{

    public function login($input)
    {
        Auth::attempt($input);
        $user = Auth::user();

        $counter = count( DB::table("oauth_access_tokens")->where("user_id", $user->id)->where("revoked", false)->get());
           if($counter === 2 || $counter > 2){
            return response()->json([
                "data" => "You are login from 2 devices."
            ], 301);
           }
        $token = $user->createToken("example")->accessToken;

        return response()->json([
            "token" => $token
        ]);
    }


    //Logout Method

    public function logout()
    {
        if(Auth::guard('api')->check())
        {
            $accessToken = Auth::guard('api')->user()->token();
    
            DB::table('oauth_refresh_tokens')
                ->where("access_token_id", $accessToken->id)
                ->update(['revoked' => true]);
            $accessToken->revoke();
    
            return response()->json([
                'data' => "Unauthorized", "message" => "user logout successfully."
            ], 200);
        }
        return response()->json([
            "data" => "Unauthorized | Not Login"
        ], 401);
    }



    //Get User

    public function getUser(){
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            $counter = count( DB::table("oauth_access_tokens")->where("user_id", $user->id)->where("revoked", false)->get());
            return response()->json([
                "data" => $user, "Counter Of Login IS : " => $counter
            ], 200);
        }
        return response()->json([
            "data" => "Unauthorized"
        ], 401);
    }


}