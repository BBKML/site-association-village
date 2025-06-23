<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('category')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        // Gestion de la date de publication
        if ($request->filled('published_at')) {
            $validated['published_at'] = $request->published_at;
        }

        $validated['user_id'] = Auth::id() ?: 1;
        $validated['is_featured'] = $request->has('is_featured');

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $imagePath;
        }

        // Gestion de la date de publication
        if ($request->filled('published_at')) {
            $validated['published_at'] = $request->published_at;
        }

        $validated['is_featured'] = $request->has('is_featured');

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Supprimer l'image associée
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès !');
    }
}
