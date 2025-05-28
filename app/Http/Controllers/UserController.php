<?php

namespace App\Http\Controllers;

use App\Models\announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::where('is_approved','=',0)->get();
        return $users;
        //
    }

    public function accept(User $user){
            $user->is_approved = true;
            $user->save();
            return ['message' => 'Utilisateur approuvé.'];
    }
    public function deny(User $user){
        $user->delete();
        return ['message' => 'Utilisateur supprimé.'];
}
    
public function events()
{
   $results = Event::all();
    return $results;
    //
}  

public function announcements()
{  $result = announcement::all();
   return $result;
    //
}
    //
}
