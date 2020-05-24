<?php

namespace App\Events;

use App\Blog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogCreatedEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Blog $blog;

    /**
     * Create a new event instance.
     *
     * @param $blog
     */
    public function __construct($blog) {
        $this->blog = $blog;
    }
}
