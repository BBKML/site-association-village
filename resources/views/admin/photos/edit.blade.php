@extends('layouts.admin')

@section('title', 'Modifier la Photo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Modifier la Photo</h1>
        <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.photos.update', $photo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $photo->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $photo->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="gallery_id" class="form-label">Galerie</label>
                            <select class="form-select @error('gallery_id') is-invalid @enderror" 
                                    id="gallery_id" name="gallery_id">
                                <option value="">Aucune galerie</option>
                                @foreach($galleries as $gallery)
                                    <option value="{{ $gallery->id }}" {{ old('gallery_id', $photo->gallery_id) == $gallery->id ? 'selected' : '' }}>
                                        {{ $gallery->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gallery_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            @if($photo->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->title }}" class="img-thumbnail" style="max-width: 150px; height: auto;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('admin.photos.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 