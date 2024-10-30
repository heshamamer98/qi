<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class commentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $comment;

    public function __construct($user, $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    public function broadcastWith(): array
    {
        return [
            'user' => [
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'comment' => $this->comment,
            'created_at' => now()->diffForHumans()
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('commentChannel'),
        ];
    }
}
