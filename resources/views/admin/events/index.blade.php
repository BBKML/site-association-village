@extends('layouts.admin')

@section('title', 'Gestion des Événements')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des événements</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un événement
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
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $event->title }}</div>
                                    @if($event->description)
                                        <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $event->date ? $event->date->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $event->location ?? '-' }}</td>
                                <td>
                                    @if($event->date && $event->date->isFuture())
                                        <span class="badge bg-success">À venir</span>
                                    @else
                                        <span class="badge bg-secondary">Passé</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
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
                                <td colspan="5" class="text-center text-muted">
                                    Aucun événement trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($events->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 