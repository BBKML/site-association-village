@extends('layouts.admin')

@section('title', 'Détail de la Photo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détail de la Photo</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.photos.edit', $photo) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @if($photo->image)
                    <div class="col-md-4">
                        <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->title }}" class="img-fluid rounded">
                    </div>
                @endif
                <div class="col-md-{{ $photo->image ? '8' : '12' }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <p class="h5">{{ $photo->title }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p>{{ $photo->description ?: 'Aucune description' }}</p>
                    </div>
                    
                    @if($photo->gallery)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Galerie</label>
                        <p>{{ $photo->gallery->name }}</p>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date de création</label>
                        <p>{{ $photo->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($photo->updated_at != $photo->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dernière modification</label>
                        <p>{{ $photo->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 