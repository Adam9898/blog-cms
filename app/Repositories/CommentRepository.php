<?php


namespace App\Repositories;


use App\Comment;

class CommentRepository {

    public function insertComment(Comment $comment) {
        $comment->save();
    }

    public function deleteComment(Comment $comment) {
        $comment->delete();
    }

}
