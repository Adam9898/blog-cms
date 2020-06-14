<?php

namespace App\Notifications;

use App\Blog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogCreated extends Notification implements ShouldQueue {
    use Queueable;

    private Blog $blog;
    private $data = [
        'blogAuthor' => null,
        'blogTitle' => null,
        'url' => null
    ];

    /**
     * Create a new notification instance.
     *
     * @param $blog
     */
    public function __construct($blog) {
        $this->blog = $blog;
        $this->data['blogAuthor'] = $this->blog->user->name;
        $this->data['blogTitle'] = $this->blog->title;
        $this->data['url'] = 'blogs/' . $this->blog->id;
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

    public function toBroadcast($notifiable) {
        return new BroadcastMessage($this->data);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return $this->data;
    }
}
