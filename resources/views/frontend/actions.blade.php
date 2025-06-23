@extends('layouts.app')

@section('title', 'Nos Actions - Association du Village')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Nos Actions et Projets</h1>
            <p class="lead text-center mb-5">
                Découvrez les différentes actions et projets que notre association mène pour améliorer la vie de notre village.
            </p>
        </div>
    </div>

    @if($projects->count() > 0)
        <div class="row">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-project-diagram fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text text-muted">
                                <small>
                                    <i class="fas fa-calendar-alt"></i> 
                                    {{ $project->start_date ? $project->start_date->format('d/m/Y') : 'Date non définie' }}
                                    @if($project->end_date)
                                        - {{ $project->end_date->format('d/m/Y') }}
                                    @endif
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit($project->description, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">{{ $project->status }}</span>
                                @if($project->budget)
                                    <small class="text-muted">Budget: {{ number_format($project->budget, 0, ',', ' ') }} €</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="#" class="btn btn-outline-primary btn-sm">En savoir plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Aucun projet en cours</h4>
                    <p>Nous n'avons pas encore de projets à afficher. Revenez bientôt pour découvrir nos nouvelles actions !</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Section des actions en cours -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Actions en Cours</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-leaf"></i> Développement Durable</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Nous travaillons activement sur des projets de développement durable pour notre village :</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Installation de panneaux solaires</li>
                        <li><i class="fas fa-check text-success"></i> Création d'espaces verts</li>
                        <li><i class="fas fa-check text-success"></i> Sensibilisation au tri sélectif</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> Cohésion Sociale</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Nos actions pour renforcer les liens entre habitants :</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-primary"></i> Organisation d'événements communautaires</li>
                        <li><i class="fas fa-check text-primary"></i> Soutien aux personnes âgées</li>
                        <li><i class="fas fa-check text-primary"></i> Activités pour les jeunes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Section pour rejoindre l'association -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body text-center">
                    <h3>Vous souhaitez participer à nos actions ?</h3>
                    <p class="lead">Rejoignez notre association et contribuez à l'amélioration de notre village !</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope"></i> Nous contacter
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-info-circle"></i> En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 