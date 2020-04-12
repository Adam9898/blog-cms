<?php


namespace App\Repositories;


use App\Blog;

class BlogRepository
{
    public function getSpecificBlog($blogId) {
        return Blog::find($blogId);
    }

    public function deleteSpecificBlog($blogId) {
        Blog::destroy($blogId);
    }


}
