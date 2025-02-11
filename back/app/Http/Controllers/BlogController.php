<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BlogResource::collection(Blog::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        if (! Gate::inspect('create', Blog::class)->allowed()) {
            abort(403);
        }
        $blog = $request->user()->blogs()->create($request->validated());

        return Blogresource::make($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return BlogResource::make($blog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if (! Gate::inspect('update', $blog)->allowed()) {
            abort(403);
        }
        $blog->update($request->validated());

        return BlogResource::make($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (! Gate::inspect('delete', $blog)->allowed()) {
            abort(403);
        }
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully.',
            'data' => $blog,
        ], Response::HTTP_ACCEPTED);
    }
}
