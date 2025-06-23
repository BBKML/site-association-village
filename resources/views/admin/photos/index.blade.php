@extends('layouts.admin')

@section('title', 'Gestion des Photos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestion des photos</h1>
        <a href="{{ route('admin.photos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter une photo
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
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($photos as $photo)
                            <tr>
                                <td>
                                    @if($photo->image)
                                        <img src="{{ Storage::url($photo->image) }}" alt="{{ $photo->title }}" class="img-thumbnail" style="height: 64px; width: 64px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Aucune image</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $photo->title }}</td>
                                <td>{{ Str::limit($photo->description, 50) }}</td>
                                <td>{{ $photo->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.photos.show', $photo) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.photos.edit', $photo) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')">
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
                                    Aucune photo trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($photos->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $photos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 