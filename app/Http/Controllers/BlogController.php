<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {

        $cachedBlog = Redis::get('blog_' . $id);


        if(isset($cachedBlog)) {
            $blog = json_decode($cachedBlog, FALSE);
            $message =  'Fetched from redis';
        }else {
            $blog = Blog::find($id);
            Redis::set('blog_' . $id, $blog);
            $message =  'Fetched from database';

        }

        return response()->json([
            'status_code' => 201,
            'message' => $message,
            'data' => $blog,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setCache(Request $request)
    {
        //
        $blogs = Blog::all();
//        dd($blogs);
//        Redis::set('blogs',  json_encode($blogs));
//        Redis::set('blogs',  json_encode($blogs));
//        Redis::hSet('blogs_test','w',  json_encode($blogs));
        Redis::lpush('blogs_test','w2','w3','w4',  json_encode($blogs));

        return response()->json([
            'status_code' => 201,
            'message' => 'Cahced Set',
            'data' => $blogs,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
