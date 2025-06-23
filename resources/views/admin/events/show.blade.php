@extends('layouts.admin')

@section('title', 'Détails de l\'Événement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détails de l'événement</h1>
        <div>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Titre :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->title }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Description :</strong>
                        </div>
                        <div class="col-sm-9">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Date et heure :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->date ? $event->date->format('d/m/Y H:i') : 'Non définie' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Lieu :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->location ?? 'Non défini' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Statut :</strong>
                        </div>
                        <div class="col-sm-9">
                            @if($event->date && $event->date->isFuture())
                                <span class="badge bg-success">À venir</span>
                            @else
                                <span class="badge bg-secondary">Passé</span>
                            @endif
                        </div>
                    </div>

                    @if($event->participants)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Participants :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->participants }}
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Date de création :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Dernière modification :</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $event->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier l'événement
                        </a>
                        
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                <i class="fas fa-trash me-2"></i>Supprimer l'événement
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>Liste des événements
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 