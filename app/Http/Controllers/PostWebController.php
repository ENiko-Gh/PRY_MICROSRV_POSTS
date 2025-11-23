<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostWebController extends Controller
{
    /**
     * Muestra la lista de posts desde la base de datos.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        Post::create($request->only('title', 'content', 'author'));

        return redirect()->route('posts.index')->with('success', '✅ ¡El nuevo artículo se ha guardado exitosamente!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->only('title', 'content', 'author'));

        return redirect()->route('posts.index')->with('success', '📝 Artículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', '🗑️ Artículo eliminado correctamente.');
    }
}
