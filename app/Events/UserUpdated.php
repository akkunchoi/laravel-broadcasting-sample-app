<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;

class UserUpdated implements ShouldBroadcast
{
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('hoge');
    }
    
    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id, 
                'name' => $this->user->name
            ]
        ];
    }    
}