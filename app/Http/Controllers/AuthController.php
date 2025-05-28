<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
 use Hash;
 use Str;
class AuthController extends Controller
{
    public function login(Request $request){
        
        $fields = $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required'
        ]);
        $user = User::where('email',$request->email)->first();
          if(!$user || !Hash::check($request->password,$user->password)) {
             return [
                'errors' =>[
                    'email' =>["the currents credentials are incorrect"]
                ] 
             ];
          }
          else if($user->role=='user' && !$user->is_approved){
            return [
                'message' => "You are not yet authorized to log in"
             ];
          }
        $token = $user->createToken($request->email);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ]; 
    }
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:8'
        ]);
        $email = $request->email;
        if(Str::contains($email,"admin")) $role="admin";

        $user = User::create([...$fields,"role"=>$role,"is_approved"=>true]);
        $token = $user->createToken($request->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return [
            'message' => " you are logged out"
        ] ;
    }
}
