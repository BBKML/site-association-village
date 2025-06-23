<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Gestion de l'image avec optimisation
        if ($request->hasFile('image')) {
            $imageService = app(\App\Services\ImageService::class);
            $sizes = \App\Services\ImageService::getDefaultSizes();
            $result = $imageService->optimizeAndSave($request->file('image'), 'teams', $sizes);
            $validated['image'] = $result['original'];
        }

        $validated['is_active'] = $request->has('is_active');

        Team::create($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Membre d\'équipe ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Gestion de l'image avec optimisation
        if ($request->hasFile('image')) {
            $imageService = app(\App\Services\ImageService::class);
            $sizes = \App\Services\ImageService::getDefaultSizes();
            
            // Supprimer l'ancienne image et ses variantes
            if ($team->image) {
                $imageService->deleteImage($team->image, array_keys($sizes));
            }
            
            $result = $imageService->optimizeAndSave($request->file('image'), 'teams', $sizes);
            $validated['image'] = $result['original'];
        }

        $validated['is_active'] = $request->has('is_active');

        $team->update($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Membre d\'équipe mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        // Supprimer l'image associée et ses variantes
        if ($team->image) {
            $imageService = app(\App\Services\ImageService::class);
            $sizes = \App\Services\ImageService::getDefaultSizes();
            $imageService->deleteImage($team->image, array_keys($sizes));
        }

        $team->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Membre d\'équipe supprimé avec succès !');
    }
}
