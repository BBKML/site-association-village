@extends('layouts.admin')

@section('title', 'Gestion des Articles')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un article
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
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Date de publication</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $article->title }}</div>
                                    @if($article->excerpt)
                                        <small class="text-muted">{{ Str::limit($article->excerpt, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $article->category->name ?? 'Aucune' }}</td>
                                <td>
                                    @if($article->published_at)
                                        <span class="badge bg-success">Publié</span>
                                    @else
                                        <span class="badge bg-warning">Brouillon</span>
                                    @endif
                                </td>
                                <td>{{ $article->published_at ? $article->published_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
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
                                    Aucun article trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($articles->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 