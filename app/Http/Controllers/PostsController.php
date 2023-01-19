<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        foreach($posts as $post)
        {
            $post->user = User::where('id' , '=' ,$post->user_id)->first(); 
        }
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => "required|string|max:125",
            'body' => "required"        
        ]);
        $post = Post::create([
            "user_id" => Auth::user()->id,
            "title" => $request->title,
            "body" => $request->body
        ]);
        return response()->json([
            "message" => "Post has been created successfully!",
            "post" => $post
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        if($post)
        {
            return response()->json([
                "message" => "Post found!",
                "post" => $post
            ]);
        }

        return response()->json([
            "message" => "No post exists with that id",

        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'title' => "required|string|max:125",
            'body' => "required"        
        ]);
        $post = Post::findOrFail($id);
        if($post && $post->user_id == Auth::user()->id)
        {
            $post->update([
                "title" => $request->title,
                "body" => $request->body
            ]);
            return response()->json([
                "message" => "Post has been updated successfully",
                "post" => $post
            ], 200);
        }
        return response()->json([
            "message" => "You cannot update this post or the post you're trying to update doesn't exist",
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post && $post->user_id == Auth::user()->id){
            $post->delete();
            return response()->json([
                "message" => "Post has been deleted successfully."
            ], 200);
        }
        return response()->json([
            "message" => "Unsuccessful. The post has not been found or you are not the owner of this post."
        ], 404);
    }
}
