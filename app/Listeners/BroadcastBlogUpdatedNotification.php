<?php

namespace App\Listeners;

use App\Events\BlogUpdatedEvent;
use App\Notifications\BlogUpdated;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class BroadcastBlogUpdatedNotification {

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
     * @param  BlogUpdatedEvent  $event
     * @return void
     */
    public function handle(BlogUpdatedEvent $event) {
        $users = $this->userRepository->getAll();
        Notification::send($users, new BlogUpdated($event->blog));
    }
}
