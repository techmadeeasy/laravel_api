<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
   public function register(Request $request){
       $request->validate([
           "name"=>'required|string',
           "email"=>'required|string|email|unique:users',
           "password"=>'required|required|string|confirmed',
       ]);

       $user = new User(["name"=>$request->get("name"), "email"=>$request->get("email"), "password"=>bcrypt("password")]);
       $user->save();
       return response()->json([
           "message"=>"Hey, dude!"
       ]);
   }

   public function login(Request $request){
       $request->validate([
           "email"=>'required|string|email|',
           "remember_me"=>'boolean',
       ]);

       $userCredentials = request(["email", "password"]);
       if(!Auth::attempt($userCredentials))
           return response()->json([
               "message"=>"unauthorized"
           ], 401);
           $user = $request->user();
           $tokenResult = $user->createToken("User Personal Access Token");
           $token = $tokenResult->token;
   }

}
