<?php

namespace App\Notifications;

use App\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Routing\Route;

class BlogUpdated extends Notification {
    use Queueable;

    private Blog $blog;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($blog) {
        $this->blog = $blog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            'blogTitle' => $this->blog->title,
            'blogAuthor' => $this->blog->user->name,
            'url' => '/blogs/' . $this->blog->id
        ];
    }
}
