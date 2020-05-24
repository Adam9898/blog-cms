<?php

namespace App\Listeners;

use App\Events\BlogCreatedEvent;
use App\Notifications\BlogCreated;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class BroadcastBlogCreatedNotification {

    private UserRepository $userRepository;

    /**
     * Create the event listener.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  BlogCreatedEvent  $event
     * @return void
     */
    public function handle(BlogCreatedEvent $event) {
        $users = $this->userRepository->getAll();
        Notification::send($users, new BlogCreated($event->blog));
    }
}
