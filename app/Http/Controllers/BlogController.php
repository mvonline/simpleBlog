<?php

namespace App\Http\Controllers;

use App\Http\Requests\creatBlogRequest;
use App\Models\Blog;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    public function getAllBlogs(): JsonResponse
    {
        $blogs = Blog::query()->get();
        return response()->json($blogs, 200);
    }


    public function getBlog(Blog $blog) {
            return response($blog, 200);
    }

    public function create(creatBlogRequest $request)
    {
//        $request->tags = json_encode($request->tags);
        $blog = array();
        $blog['title'] = $request->title;
        $blog['text'] = $request->text;
        $blog['tags'] = json_encode($request->tags);

        $blog = Blog::query()->create($blog);
        return response($blog, 200);
    }

    public function update(Request $request, Blog $blog): JsonResponse
    {
//        if ($blog::query()->exists()) {

            $blog->title = is_null($request->title) ? $blog->title : $request->title;
            $blog->text = is_null($request->text) ? $blog->text : $request->text;
            $blog->tags = is_null($request->tags) ? $blog->tags : json_encode($request['tags']);
            $blog->save();

            return response()->json([
                "message" => "records updated successfully",
                "data" => $blog
            ], 200);
//        } else {
//            return response()->json([
//                "message" => "Blog not found"
//            ], 404);
//        }
    }

    /**
     * @param Blog $blog
     * @return JsonResponse
     * @throws Exception
     */
    public function delete (Blog $blog): JsonResponse
    {
        $blog->delete();
        return response()->json([
            "message" => "records deleted"
        ], 202);
    }




}
