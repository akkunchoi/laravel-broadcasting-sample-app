<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use \App\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            $uniqid = 'guest_' . uniqid();
            $user = new User();
            $user->name = $uniqid;
            $user->email = $uniqid . '@example.com';
            $user->password = $uniqid;
            $user->save();
            Auth::login($user);
        }
        
        return view('welcome', ['user' => $user]);
    }
}