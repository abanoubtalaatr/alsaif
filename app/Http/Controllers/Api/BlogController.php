<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlogRequest;
use App\Http\Requests\Api\UpdateBlogRequest;
use App\Http\Resources\Api\BlogResource;

class BlogController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = BlogResource::collection( Blog::all());

        return $this->success($blogs, 'Blogs fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $blog = Blog::create($request->validated());

        return $this->success(BlogResource::make($blog), 'Blog created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return $this->success(BlogResource::make($blog), 'Blog fetched successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());   

        return $this->success(BlogResource::make($blog->refresh()), 'Blog updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return $this->success(null, 'Blog deleted successfully', 200);
    }
}
