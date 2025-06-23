<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries = Gallery::all();
        return view('admin.photos.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_id' => 'nullable|exists:galleries,id',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('photos', 'public');
            $validated['image'] = $imagePath;
        }

        Photo::create($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        return view('admin.photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        $galleries = Gallery::all();
        return view('admin.photos.edit', compact('photo', 'galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_id' => 'nullable|exists:galleries,id',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            $imagePath = $request->file('image')->store('photos', 'public');
            $validated['image'] = $imagePath;
        }

        $photo->update($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        // Supprimer l'image associée
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()->route('admin.photos.index')
            ->with('success', 'Photo supprimée avec succès !');
    }
}
