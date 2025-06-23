@extends('layouts.admin')

@section('title', 'Gestion de l\'Équipe')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion de l'équipe</h1>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un membre
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
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teams as $member)
                            <tr>
                                <td>
                                    @if($member->image)
                                        <img src="{{ Storage::url($member->image) }}" class="img-thumbnail rounded-circle" style="height: 48px; width: 48px; object-fit: cover;" alt="{{ $member->name }}">
                                    @else
                                        <span class="text-muted"><i class="fas fa-user"></i></span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $member->name }}<br><small class="text-muted">{{ Str::limit($member->bio, 50) }}</small></td>
                                <td>{{ $member->position }}</td>
                                <td>{{ $member->email ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.teams.show', $member) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.teams.edit', $member) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.teams.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
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
                                    Aucun membre d'équipe trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($teams->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $teams->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 