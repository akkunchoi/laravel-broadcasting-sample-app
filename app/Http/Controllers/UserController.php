<?php

namespace App\Http\Controllers;

use App\Events\UserUpdated;
use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $name = $request->get('name');
        if ($name) {
            $user->name = $name;
            $user->save();
        }
        broadcast(new UserUpdated($user))->toOthers();
        
        return ['status' => 200];
    }
}