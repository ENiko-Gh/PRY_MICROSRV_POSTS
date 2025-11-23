<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json([
            'message' => 'Post creado exitosamente',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json([
            'message' => 'Post actualizado exitosamente',
            'post' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post no encontrado'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post eliminado exitosamente'
        ], 200);
    }
}
