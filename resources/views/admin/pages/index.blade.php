@extends('layouts.admin')

@section('title', 'Gestion des Pages')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter une page
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
                            <th>Slug</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td class="fw-bold">{{ $page->title }}</td>
                                <td><code class="bg-light px-2 py-1 rounded">{{ $page->slug }}</code></td>
                                <td>
                                    @if($page->is_published)
                                        <span class="badge bg-success">Publiée</span>
                                    @else
                                        <span class="badge bg-warning">Brouillon</span>
                                    @endif
                                </td>
                                <td>{{ $page->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette page ?')">
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
                                    Aucune page trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($pages->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $pages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 