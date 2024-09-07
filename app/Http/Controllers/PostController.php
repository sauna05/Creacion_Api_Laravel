<?php

// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id; // Obtén el ID del usuario autenticado
        $posts=Post::where('user_id', $userId)->get();
        return response()->json($posts);
    }

    public function store(Request $request) {
       $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $user=Auth::user();
        $post=new Post($request->all());
        $post->user_id=$user->id;
        $post->save();
        return response()->json($post, 201);
    }

    public function show($id) {
        return Post::find($id);
    }

    public function update(Request $request, $id) {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id) {
        Post::destroy($id);
        return response()->json(null, 204);
    }
    
}



