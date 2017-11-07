<?php

namespace App\Http\Controllers;

use App\Events\WorkCreated;
use App\User;
use Illuminate\Broadcasting\PrivateChannel;

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
        event(new WorkCreated('hoge'));
        
        return ['status' => 200];
    }
}