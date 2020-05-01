<?php

namespace App\Policies;

use App\Comment;
use App\Repositories\BlogRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class CommentPolicy {

    use HandlesAuthorization;

    private $blogRepository;

    public function __construct(BlogRepository $blogRepository) {
        $this->blogRepository = $blogRepository;
    }

    public function create(User $user, Comment $comment) {
        $blog = $this->blogRepository->getSpecificBlog($comment->blog->id);
        return $blog !== null;
    }

    public function delete(User $user, Comment $comment) {
        return $comment->user->getAuthIdentifier() == $user->getAuthIdentifier();
    }
}
