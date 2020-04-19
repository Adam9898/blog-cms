<?php


namespace App\Repositories;


use App\Blog;
use Illuminate\Support\Facades\DB;

class BlogRepository {

    public function getSpecificBlog($blogId) {
        return Blog::find($blogId);
    }

    public function deleteSpecificBlog($blogId) {
        Blog::destroy($blogId);
    }

    public function getBlogsAndLimit($limit) {
        $returnValue = DB::select('SELECT * FROM blogs ORDER BY created_at LIMIT ?', [$limit]);
        if (sizeof($returnValue) < 1) {
            $returnValue = null;
        }
        return $returnValue;
    }

    public function insertBlog(Blog $blog) {
        $blog->save();
    }

}
