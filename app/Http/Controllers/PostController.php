<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $post = Post::all();
        return PostResource::collection($post);
    }

    public function show($id) {
        $post = Post::with('writer')->findOrFail($id);
        return new PostDetailResource($post);
    }

    public function show2($id){
        $post = Post::findOrFail($id);
        return new PostDetailResource($post);
    }
}
