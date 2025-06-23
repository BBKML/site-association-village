@extends('layouts.admin')

@section('title', 'Gestion des Projets')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des projets</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un projet
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Statut</th>
                            <th>Dates</th>
                            <th>Budget</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    @if($project->image)
                                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="img-thumbnail" style="height: 64px; width: 64px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Aucune image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $project->title }}</div>
                                    <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'planning' => 'bg-warning',
                                            'in_progress' => 'bg-primary',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        $statusLabels = [
                                            'planning' => 'Planification',
                                            'in_progress' => 'En cours',
                                            'completed' => 'Terminé',
                                            'cancelled' => 'Annulé'
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$project->status] }}">{{ $statusLabels[$project->status] }}</span>
                                </td>
                                <td>
                                    @if($project->start_date)
                                        <div>Début: {{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</div>
                                    @endif
                                    @if($project->end_date)
                                        <div>Fin: {{ \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($project->budget)
                                        {{ number_format($project->budget, 2) }} Fcfa
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Aucun projet trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($projects->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 