<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Enums\UserRole;
use App\Http\Requests\BlogRequest;
use App\Repositories\BlogRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller {

    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository) {
        $this->middleware('role:' . UserRole::Editor)->except('show');
        $this->blogRepository = $blogRepository;
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
        $blogId = $this->blogRepository->insertBlog($blog);
        return redirect()->route('blogs.show', ['blog' => $blogId]);
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blog
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
    public function edit(Blog $blogs) {
        $this->authorize('update', Blog::class);
        return view('blog.edit', compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blogs) {
        $this->authorize('update', Blog::class);
        $this->blogRepository->updateBlog($request->post(), $blogs);
        return redirect()->route('blog.show', ['blog' => $blogs->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->authorize('delete', Blog::class);
        $this->blogRepository->deleteSpecificBlog($id);
        return redirect()->home();
    }
}
