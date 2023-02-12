<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'posts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::has('posts')->public()->get();

        return PostResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::public()->findOrFail($id));        
    }

    /**
     * Display all author posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function posts($id)
    {
        User::public()->findOrFail($id);
        
        $posts = Post::where('user_id', $id)->orderBy('id', 'desc')->paginate();

        return PostResource::collection($posts);
    }
}
