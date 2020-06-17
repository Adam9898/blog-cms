<?php


namespace App\Repositories;


use App\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogRepository {

    public function getSpecificBlog($blogId) {
        return Blog::find($blogId);
    }

    public function deleteSpecificBlog(Blog $blog) {
        $blog->delete();
    }

    public function getBlogsAndLimit($limit) {
        $returnValue = DB::select('SELECT * FROM blogs ORDER BY created_at LIMIT ?', [$limit]);
        if (sizeof($returnValue) < 1) {
            $returnValue = null;
        }
        return $returnValue;
    }

    public function getPaginatedBlogs() {
        return Blog::latest()->paginate(16);
    }

    public function insertBlog(Blog $blog) {
        $blog->save();
        return $blog->id;
    }

    public function updateBlog(array $data, Blog $blog) {
        return $blog->update($data);
    }

}
