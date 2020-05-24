<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Enums\UserRole;
use App\Http\Requests\BlogRequest;
use App\Notifications\BlogCreated;
use App\Notifications\BlogUpdated;
use App\Repositories\BlogRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller {

    protected $blogRepository;
    protected $userRepository;

    public function __construct(BlogRepository $blogRepository, UserRepository $userRepository) {
        $this->middleware('role:' . UserRole::Editor)->except('show');
        $this->blogRepository = $blogRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('blog.create');
    }

    /**
     * Store a newly created blog post in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BlogRequest $request) {
        $blog = new Blog($request->post());
        $blog->user_id = Auth::user()->getAuthIdentifier();
        $blogId = $this->blogRepository->insertBlog($blog);
        event(new BlogCreated($blog));
        return redirect()->route('blogs.show', ['blog' => $blogId]);
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blogs
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blogs) {
       return view('blog.show', compact('blogs'));
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param Blog $blog
     * @return void
     */
    public function edit(Blog $blog) {
        $this->authorize('update', $blog);
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog) {
        $this->authorize('update', $blog);
        $this->blogRepository->updateBlog($request->post(), $blog);
        event(new BlogUpdated($blog));
        return redirect()->route('blogs.show', ['blog' => $blog->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog) {
        $this->authorize('delete', $blog);
        $this->blogRepository->deleteSpecificBlog($blog);
        return redirect()->home();
    }
}
