<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function index()
    {
        return Message::with('user')->orderBy('id', 'desc')->get();
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $text = $request->input('text');
        
        $message = new Message([
            'text' => $text
        ]);
        $message->user()->associate($user);
        $message->save();
        
        event(new MessageCreated($message));
        
        return ['status' => 200];
    }
}