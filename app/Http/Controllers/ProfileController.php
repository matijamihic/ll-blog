<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserResource(User::findOrFail(Auth::id()));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->toArray();
        $user = User::findOrFail(Auth::id());
        $user->update($data);

        return response()->json(['message' => 'Profile updated'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display all user posts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function posts()
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->without('user')
            ->withTrashed()
            ->paginate();
    
        return PostResource::collection($posts);
    }

    public function post($id)
    {
        $post = Post::whereHas('user', function ($q) {
            $q->where('id', Auth::id());
        })
        ->withTrashed()
        ->findOrFail($id);

        return new PostResource($post);
    }
}
