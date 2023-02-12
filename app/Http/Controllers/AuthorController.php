<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($id != Auth::id()) {
            return new UserResource(User::public()->findOrFail($id));    
        }

        return new UserResource(User::findOrFail($id));    
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id != Auth::id()) {
            
            return response()->json(['message' => 'Not authorized'], 200)->header('Content-Type', 'application/json');
        }

        $data = $request->toArray();

        $user = User::findOrFail($id);

        $user->update($data);

        return response()->json(['message' => 'Profile updated'], 200)->header('Content-Type', 'application/json');
    }
}
