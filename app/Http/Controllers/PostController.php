<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'tags', 'withAllTags', 'withAnyTags']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->toArray();

        $post = new Post($data);
        $post->user_id = Auth::id();
        $post->save();

        $post->tag($request->tags);
        $post->save();

        $post->load('user');

        return response()->json(['message' => 'Post created'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user->id !== Auth::id()) {
            return response()->json(['message' => 'Not authorized'], 200)->header('Content-Type', 'application/json');
        }

        $data = $request->toArray();
        $post->tag($request->tags);    
        $post->update($data);

        return response()->json(['message' => 'Post updated'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->user->id !== Auth::id()) {
            return response()->json(['message' => 'Not authorized'], 200)->header('Content-Type', 'application/json');
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * List all tags
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function tags()
    {
        $tags = Post::popularTags();

        return response()->json([
            'data' => $tags
        ], 200);    
    }

    /**
     * Display a listing of the posts with that include any of suplied tags 
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function withAnyTags($tags)
    {
        $post = Post::withAnyTags($tags)->paginate();

        return response()->json([
            'data' => $post
        ], 200);    
    }

    /**
     * Display a listing of the posts with that include all of suplied tags 
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function withAllTags($tags)
    {
        $post = Post::withAllTags($tags)->paginate();

        return response()->json([
            'data' => $post
        ], 200);    
    }
}
