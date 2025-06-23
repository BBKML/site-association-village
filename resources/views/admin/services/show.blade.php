@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du service</h1>
        <div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du service</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Nom du service</h5>
                            <p class="text-muted">{{ $service->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Prix</h5>
                            <p class="text-muted">
                                @if($service->price)
                                    {{ number_format($service->price, 2) }} FCFA
                                @else
                                    <span class="text-muted">Non spécifié</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h5>Description</h5>
                            <p class="text-muted">{{ $service->description }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Statut</h5>
                            <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $service->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h5>Date de création</h5>
                            <p class="text-muted">{{ $service->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Image</h6>
                </div>
                <div class="card-body text-center">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="img-fluid rounded" 
                             style="max-height: 300px;">
                    @else
                        <div class="text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Aucune image</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 