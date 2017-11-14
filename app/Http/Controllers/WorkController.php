<?php

namespace App\Http\Controllers;

use App\Events\WorkCreated;
use App\User;
use Auth;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $count = $request->input('count');
        
        $user->clap = $user->clap + $count;
        $user->save();
        
        event(new WorkCreated($user, ['count' => $count]));
        
        return ['status' => 200];
    }
}