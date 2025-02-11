<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        return PostResource::collection($blog->posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, Blog $blog)
    {
        if (! Gate::inspect('create', [Post::class, $blog])->allowed()) {
            abort(403);
        }
        $post = $blog->posts()->create($request->validated());

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, Post $post)
    {
        if (! Gate::inspect('view', [$post, $blog])->allowed()) {
            abort(403);
        }

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Blog $blog, Post $post)
    {
        if (! Gate::inspect('update', [$post, $blog])->allowed()) {
            abort(403);
        }
        $post->update($request->validated());

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, Post $post)
    {
        if (! Gate::inspect('delete', [$post, $blog])->allowed()) {
            abort(403);
        }
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully.',
            'data' => $post,
        ], Response::HTTP_ACCEPTED);
    }
}
