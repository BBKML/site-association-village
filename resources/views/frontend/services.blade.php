@extends('layouts.app')

@section('title', 'Services Locaux - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Services Locaux</h1>
            <p class="lead">Découvrez les commerçants, artisans et services de notre village</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2>Nos Services</h2>
                    <p class="lead">Tout ce dont vous avez besoin dans notre village</p>
                </div>
            </div>

            <!-- Filtres -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" data-filter="all">Tous</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="Commerce">Commerce</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="Artisanat">Artisanat</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="Santé">Santé</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="Éducation">Éducation</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="Public">Services Publics</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des services -->
            <div class="row" id="services-container">
                @forelse($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4 service-item" data-type="{{ $service->type }}">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0">
                                        @switch($service->type)
                                            @case('Commerce')
                                                <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                                                @break
                                            @case('Artisanat')
                                                <i class="fas fa-hammer fa-2x text-primary"></i>
                                                @break
                                            @case('Santé')
                                                <i class="fas fa-heartbeat fa-2x text-primary"></i>
                                                @break
                                            @case('Éducation')
                                                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                                                @break
                                            @case('Public')
                                                <i class="fas fa-building fa-2x text-primary"></i>
                                                @break
                                            @default
                                                <i class="fas fa-cog fa-2x text-primary"></i>
                                        @endswitch
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="card-title mb-0">{{ $service->name }}</h5>
                                        <small class="text-muted">{{ $service->type }}</small>
                                    </div>
                                </div>
                                
                                @if($service->description)
                                    <p class="card-text">{{ $service->description }}</p>
                                @endif
                                
                                @if($service->contact)
                                    <div class="mt-3">
                                        <strong>Contact :</strong>
                                        <p class="mb-0">{{ $service->contact }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Aucun service disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Informations pratiques -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2>Informations Pratiques</h2>
                    <p class="lead">Horaires et informations utiles</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-clock text-primary me-2"></i>
                                Horaires d'ouverture
                            </h5>
                            <ul class="list-unstyled">
                                <li><strong>Lundi - Vendredi :</strong> 8h - 17h</li>
                                <li><strong>Samedi :</strong> 9h - 12h</li>
                                <li><strong>Dimanche :</strong> Fermé</li>
                            </ul>
                            <small class="text-muted">* Horaires variables selon les commerces</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Localisation
                            </h5>
                            <p class="card-text">La plupart de nos services sont situés dans le centre du village, facilement accessibles à pied.</p>
                            <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-directions me-1"></i>Plan d'accès
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
        <div class="container text-center">
            <h2 class="mb-4">Vous êtes un commerçant ou artisan ?</h2>
            <p class="lead mb-4">Rejoignez notre annuaire et faites connaître votre activité aux habitants du village.</p>
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus me-2"></i>Ajouter mon service
            </a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const serviceItems = document.querySelectorAll('.service-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Mettre à jour les boutons actifs
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrer les services
            serviceItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-type') === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush 