<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['creator', 'category'])->get();

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'creator_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->published_at = $validated['published_at'] ?? now();
        $post->creator_id = $validated['creator_id'];
        $post->category_id = $validated['category_id'];
        $post->save();

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) //tambien se usar Post $post enves de string
    {
        $post = Post::with(['creator', 'category'])->findOrFail($id);

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)  //tambien se usar Post $post enves de string
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'published_at' => ['sometimes', 'date'],
            'creator_id' => ['sometimes', 'exists:users,id'],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //tambien se usar Post $post enves de string
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }
}
