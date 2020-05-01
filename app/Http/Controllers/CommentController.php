<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Enums\UserRole;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

    private $commentRepository;

    public function __construct(CommentRepository $commentRepository) {
        $this->middleware('role:' . UserRole::Regular);
        $this->commentRepository = $commentRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request) {
        $comment = new Comment($request->post());
        $comment->blog_id = $request->post()['blog'];
        $comment->user_id = Auth::user()->getAuthIdentifier();
        $this->authorize('create', $comment);
        $this->commentRepository->insertComment($comment);
        return redirect()->route('blogs.show', ['blog' => $comment->blog->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment) {
        $this->authorize('delete', $comment);
        $this->commentRepository->deleteComment($comment);
        return redirect()->route('blogs.show', ['blog' => $comment->blog->id]);
    }
}
