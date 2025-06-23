@extends('layouts.admin')

@section('title', 'Détail de la Page')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Détail de la Page</h1>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Titre</label>
                <p class="h5">{{ $page->title }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Slug (URL)</label>
                <p class="text-muted">{{ $page->slug }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Contenu</label>
                <div class="bg-light p-3 rounded border">
                    {!! $page->content !!}
                </div>
            </div>

            @if($page->meta_description)
            <div class="mb-3">
                <label class="form-label fw-bold">Description meta (SEO)</label>
                <p>{{ $page->meta_description }}</p>
            </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Statut</label>
                <span class="badge {{ $page->is_published ? 'bg-success' : 'bg-danger' }}">
                    {{ $page->is_published ? 'Publiée' : 'Non publiée' }}
                </span>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Date de création</label>
                <p>{{ $page->created_at->format('d/m/Y H:i') }}</p>
            </div>

            @if($page->updated_at != $page->created_at)
            <div class="mb-3">
                <label class="form-label fw-bold">Dernière modification</label>
                <p>{{ $page->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 