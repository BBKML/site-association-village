@extends('layouts.admin')

@section('title', 'Détail du Projet')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détail du Projet</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                @if($project->image)
                    <div class="col-md-4">
                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded">
                    </div>
                @endif
                <div class="col-md-{{ $project->image ? '8' : '12' }}">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <p class="h5">{{ $project->title }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p>{{ $project->description }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        @php
                            $statusColors = [
                                'planning' => 'badge bg-warning',
                                'in_progress' => 'badge bg-primary',
                                'completed' => 'badge bg-success',
                                'cancelled' => 'badge bg-danger'
                            ];
                            $statusLabels = [
                                'planning' => 'Planification',
                                'in_progress' => 'En cours',
                                'completed' => 'Terminé',
                                'cancelled' => 'Annulé'
                            ];
                        @endphp
                        <span class="{{ $statusColors[$project->status] }}">
                            {{ $statusLabels[$project->status] }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dates</label>
                        <div>
                            @if($project->start_date)
                                <div>Début : {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</div>
                            @endif
                            @if($project->end_date)
                                <div>Fin : {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Budget</label>
                        <p class="h6">{{ $project->budget ? number_format($project->budget, 2) . ' FCFA' : '-' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date de création</label>
                        <p>{{ $project->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    @if($project->updated_at != $project->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dernière modification</label>
                        <p>{{ $project->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 