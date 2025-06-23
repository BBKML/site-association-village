@extends('layouts.admin')

@section('title', 'Détails de l\'Article')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détails de l'Article</h1>
        <div>
            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $article->title }}</h5>
                </div>
                <div class="card-body">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             class="img-fluid mb-3" alt="{{ $article->title }}">
                    @endif
                    
                    <div class="mb-3">
                        <h6>Contenu :</h6>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($article->content)) !!}
                        </div>
                    </div>

                    @if($article->excerpt)
                        <div class="mb-3">
                            <h6>Extrait :</h6>
                            <p class="text-muted">{{ $article->excerpt }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Informations</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID :</strong></td>
                            <td>{{ $article->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Catégorie :</strong></td>
                            <td>{{ $article->category->name ?? 'Aucune' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Statut :</strong></td>
                            <td>
                                <span class="badge bg-{{ $article->published_at ? 'success' : 'warning' }}">
                                    {{ $article->published_at ? 'Publié' : 'Brouillon' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>En vedette :</strong></td>
                            <td>
                                <span class="badge bg-{{ $article->is_featured ? 'primary' : 'secondary' }}">
                                    {{ $article->is_featured ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Date de création :</strong></td>
                            <td>{{ $article->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dernière modification :</strong></td>
                            <td>{{ $article->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @if($article->published_at)
                            <tr>
                                <td><strong>Date de publication :</strong></td>
                                <td>{{ $article->published_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 