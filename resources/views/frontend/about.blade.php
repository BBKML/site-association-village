@extends('layouts.app')

@section('title', 'À Propos - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">À Propos de Notre Association</h1>
            <p class="lead">Découvrez notre histoire, nos valeurs et nos objectifs</p>
        </div>
    </section>

    <!-- Histoire Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-4">Notre Histoire</h2>
                    <p class="lead">L'Association du Village a été fondée en 2020 avec la volonté de rassembler les habitants autour de projets communs et de préserver notre patrimoine local.</p>
                    <p>Depuis sa création, notre association s'est engagée dans de nombreux projets visant à améliorer la qualité de vie de notre communauté et à valoriser notre village auprès des visiteurs.</p>
                    <p>Nous croyons fermement que la force d'un village réside dans la solidarité de ses habitants et dans la préservation de ses traditions.</p>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-history fa-4x text-primary mb-3"></i>
                            <h4>Plus de 4 ans d'engagement</h4>
                            <p class="text-muted">Au service de notre communauté</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Valeurs Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2>Nos Valeurs</h2>
                    <p class="lead">Les principes qui guident nos actions</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-hands-helping fa-3x text-primary mb-3"></i>
                            <h5>Solidarité</h5>
                            <p>Nous croyons en la force du collectif et de l'entraide entre les habitants.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-leaf fa-3x text-primary mb-3"></i>
                            <h5>Durabilité</h5>
                            <p>Nos projets respectent l'environnement et visent un développement durable.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h5>Tradition</h5>
                            <p>Nous préservons et transmettons les traditions et le patrimoine local.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Objectifs Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2>Nos Objectifs</h2>
                    <p class="lead">Les missions que nous nous sommes fixées</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Développement Communautaire</h5>
                            <p>Favoriser les échanges intergénérationnels et créer des liens sociaux forts entre les habitants.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-landmark fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Préservation du Patrimoine</h5>
                            <p>Protéger et valoriser le patrimoine architectural, culturel et naturel de notre village.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Développement Économique</h5>
                            <p>Soutenir les artisans locaux et promouvoir le tourisme responsable dans notre région.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Éducation et Formation</h5>
                            <p>Organiser des ateliers et des formations pour transmettre les savoir-faire traditionnels.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Équipe Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2>Notre Équipe</h2>
                    <p class="lead">Les membres qui font vivre l'association</p>
                </div>
            </div>
            <div class="row">
                @forelse($teamMembers as $member)
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            @if($member->image)
                                <img src="{{ asset('storage/' . $member->image) }}" class="card-img-top" alt="{{ $member->name }}">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-user fa-4x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $member->name }}</h5>
                                <p class="card-text text-primary">{{ $member->position }}</p>
                                @if($member->bio)
                                    <p class="card-text small">{{ $member->bio }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Aucun membre d'équipe disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
        <div class="container text-center">
            <h2 class="mb-4">Rejoignez Notre Association</h2>
            <p class="lead mb-4">Participez à nos projets et contribuez au développement de notre village.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Nous Contacter</a>
                <a href="{{ route('newsletter.subscribe') }}" class="btn btn-outline-light btn-lg">S'abonner à la Newsletter</a>
            </div>
        </div>
    </section>
@endsection 