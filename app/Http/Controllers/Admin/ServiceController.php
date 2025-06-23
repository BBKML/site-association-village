<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        try {
            // Validation simplifiée
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
            ]);

            // Mise à jour simple
            $service->name = $validated['name'];
            $service->description = $validated['description'];
            $service->price = $validated['price'];
            $service->is_active = $request->has('is_active');

            // Gestion de l'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $imagePath = $request->file('image')->store('services', 'public');
                $service->image = $imagePath;
            }

            $service->save();

            return redirect()->route('admin.services.index')
                ->with('success', 'Service mis à jour avec succès !');
                
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Supprimer l'image associée
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès !');
    }
}
