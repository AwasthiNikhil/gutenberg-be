<?php

// app/Http/Controllers/Api/PostController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'required|string',
            'blocks' => 'required|array',
            'selection' => 'nullable|array',
        ]);

        // Since 'blocks' is an array, we need to encode it to a JSON string
        // before saving it to the 'longText' field.
        $validated['blocks'] = json_encode($validated['blocks']);

        // If selection data exists, encode it as well.
        if (isset($validated['selection'])) {
            $validated['selection'] = json_encode($validated['selection']);
        }

        // Create a new post in the database
        $post = Post::create($validated);

        return response()->json([
            'message' => 'Post saved successfully!',
            'post' => $post
        ], 201);
    }
    
    // ADD THIS NEW METHOD FOR FETCHING
    public function show($id)
    {
        $post = Post::findOrFail($id);

        // IMPORTANT: Decode the 'blocks' JSON string back into a PHP array
        // before sending it to the frontend.
        $post->blocks = json_decode($post->blocks, true);

        // Also decode selection if it exists
        if ($post->selection) {
            $post->selection = json_decode($post->selection, true);
        }

        return response()->json($post);
    }
}
