<?php


namespace App\Services;


use App\Repositories\BlogRepository;

class BlogService
{
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getBlogById($id) {
        return $this->blogRepository->getSpecificBlog($id);
    }
}
