<?php

namespace App\Http\Controllers;

use App\Events\WorkCreated;
use App\User;
use Auth;

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
    
    public function store()
    {
        $user = Auth::user();
        
        event(new WorkCreated($user));
        
        return ['status' => 200];
    }
}