@extends('layouts.admin')

@section('title', 'Détail du Membre')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détail du Membre</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @if($team->image)
                    <div class="col-md-4">
                        <img src="{{ Storage::url($team->image) }}" alt="{{ $team->name }}" class="img-fluid rounded">
                    </div>
                @endif
                <div class="col-md-{{ $team->image ? '8' : '12' }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom complet</label>
                        <p class="h5">{{ $team->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Poste</label>
                        <p class="h6">{{ $team->position }}</p>
                    </div>
                    
                    @if($team->bio)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Biographie</label>
                        <p>{{ $team->bio }}</p>
                    </div>
                    @endif
                    
                    <div class="row">
                        @if($team->email)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p>
                                <a href="mailto:{{ $team->email }}" class="text-decoration-none">
                                    {{ $team->email }}
                                </a>
                            </p>
                        </div>
                        @endif

                        @if($team->phone)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Téléphone</label>
                            <p>
                                <a href="tel:{{ $team->phone }}" class="text-decoration-none">
                                    {{ $team->phone }}
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <span class="badge {{ $team->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $team->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date d'ajout</label>
                        <p>{{ $team->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($team->updated_at != $team->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dernière modification</label>
                        <p>{{ $team->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 