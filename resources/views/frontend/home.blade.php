@extends('layouts.app')

@section('title', 'Accueil - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="display-4 fw-bold mb-4">Bienvenue à l'Association du Village</h1>
                <p class="lead mb-4">Développement communautaire et préservation du patrimoine local</p>
                <div class="d-flex justify-content-center gap-3 hero-buttons">
                    <a href="{{ route('about') }}" class="btn btn-primary btn-lg animate-btn">
                        <i class="fas fa-info-circle me-2"></i>Découvrir
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg animate-btn">
                        <i class="fas fa-envelope me-2"></i>Nous Contacter
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Présentation Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 text-center feature-card">
                        <div class="card-body">
                            <div class="feature-icon">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Communauté</h5>
                            <p class="card-text">Rassembler les habitants autour de projets communs et favoriser les échanges intergénérationnels.</p>
                            <a href="{{ route('about') }}" class="btn btn-outline-primary btn-sm">En savoir plus</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 text-center feature-card">
                        <div class="card-body">
                            <div class="feature-icon">
                                <i class="fas fa-leaf fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Patrimoine</h5>
                            <p class="card-text">Préserver et valoriser le patrimoine culturel et naturel de notre village.</p>
                            <a href="{{ route('gallery') }}" class="btn btn-outline-primary btn-sm">Voir la galerie</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 text-center feature-card">
                        <div class="card-body">
                            <div class="feature-icon">
                                <i class="fas fa-handshake fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Développement</h5>
                            <p class="card-text">Promouvoir le développement local durable et améliorer la qualité de vie.</p>
                            <a href="{{ route('services') }}" class="btn btn-outline-primary btn-sm">Nos services</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Actualités Récentes -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Dernières Actualités</h2>
                    <p class="lead">Restez informé de la vie de notre village</p>
                </div>
            </div>
            <div class="row">
                @forelse($recentArticles as $article)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 news-card">
                            @if($article->image)
                                <div class="news-image-container">
                                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top news-image" alt="{{ $article->title }}">
                                    <div class="news-overlay">
                                        <a href="{{ route('news.show', $article->id) }}" class="btn btn-light btn-sm">
                                            <i class="fas fa-eye me-1"></i>Lire
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ Str::limit($article->content, 150) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $article->published_at->format('d/m/Y') }}
                                    </small>
                                    <a href="{{ route('news.show', $article->id) }}" class="btn btn-sm btn-primary">Lire plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="empty-state">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <h4>Aucune actualité disponible</h4>
                            <p>Les actualités seront bientôt publiées.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('news') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-newspaper me-2"></i>Voir toutes les actualités
                </a>
            </div>
        </div>
    </section>

    <!-- Événements à Venir -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Prochains Événements</h2>
                    <p class="lead">Ne manquez pas les événements de notre village</p>
                </div>
            </div>
            <div class="row">
                @forelse($upcomingEvents as $event)
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 event-card">
                            @if($event->image)
                                <div class="event-image-container">
                                    <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top event-image" alt="{{ $event->title }}">
                                    <div class="event-date-badge">
                                        <span class="day">{{ $event->date->format('d') }}</span>
                                        <span class="month">{{ $event->date->format('M') }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <div class="event-details">
                                    <div class="event-detail">
                                        <i class="fas fa-calendar text-primary"></i>
                                        <span>{{ $event->date->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="event-detail">
                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>Voir détails
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="empty-state">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <h4>Aucun événement à venir</h4>
                            <p>Les événements seront bientôt annoncés.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('events') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar me-2"></i>Voir tous les événements
                </a>
            </div>
        </div>
    </section>

    <!-- Galerie Photos -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Galerie Photos</h2>
                    <p class="lead">Découvrez les moments forts de notre village</p>
                </div>
            </div>
            <div class="row">
                @php
                    $photosWithImages = $recentPhotos->filter(function($photo) {
                        return !empty($photo->image);
                    });
                @endphp
                @forelse($photosWithImages->take(6) as $photo)
                    <div class="col-md-4 col-lg-2 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="gallery-preview-card">
                            <a href="{{ route('gallery') }}">
                                <img src="{{ asset('storage/' . $photo->image) }}" 
                                     class="gallery-preview-image" 
                                     alt="{{ $photo->title ?? 'Photo de la galerie' }}">
                                <div class="gallery-preview-overlay">
                                    <i class="fas fa-images"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" data-aos="fade-up">
                        <div class="empty-state">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h4>Aucune photo disponible</h4>
                            <p>La galerie sera bientôt enrichie.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('gallery') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-images me-2"></i>Voir la galerie complète
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 cta-section" data-aos="fade-up">
        <div class="container text-center">
            <h2 class="mb-4">Rejoignez Notre Association</h2>
            <p class="lead mb-4">Participez au développement de notre village et contribuez à préserver notre patrimoine.</p>
            <div class="d-flex justify-content-center gap-3 cta-buttons">
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg animate-btn">
                    <i class="fas fa-user-plus me-2"></i>Devenir Membre
                </a>
                <a href="{{ route('newsletter.subscribe') }}" class="btn btn-outline-light btn-lg animate-btn">
                    <i class="fas fa-envelope me-2"></i>S'abonner à la Newsletter
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .hero-content {
        animation: fadeInUp 1s ease-out;
    }

    .hero-buttons .animate-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .hero-buttons .animate-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .hero-buttons .animate-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .hero-buttons .animate-btn:hover::before {
        left: 100%;
    }

    .hero-scroll-indicator {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        font-size: 24px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateX(-50%) translateY(0);
        }
        40% {
            transform: translateX(-50%) translateY(-10px);
        }
        60% {
            transform: translateX(-50%) translateY(-5px);
        }
    }

    .feature-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .feature-icon {
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1);
    }

    .section-title {
        position: relative;
        margin-bottom: 1rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-color);
    }

    .news-card, .event-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .news-card:hover, .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .news-image-container, .event-image-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .news-image, .event-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .news-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 51, 153, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .news-card:hover .news-image {
        transform: scale(1.1);
    }

    .news-card:hover .news-overlay {
        opacity: 1;
    }

    .event-date-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--primary-color);
        color: white;
        padding: 8px;
        border-radius: 5px;
        text-align: center;
        min-width: 50px;
    }

    .event-date-badge .day {
        display: block;
        font-size: 18px;
        font-weight: bold;
    }

    .event-date-badge .month {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
    }

    .event-details {
        margin: 1rem 0;
    }

    .event-detail {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 14px;
    }

    .event-detail i {
        margin-right: 8px;
        width: 16px;
    }

    .gallery-preview-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        height: 150px;
    }

    .gallery-preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 51, 153, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
        font-size: 24px;
    }

    .gallery-preview-card:hover .gallery-preview-image {
        transform: scale(1.1);
    }

    .gallery-preview-card:hover .gallery-preview-overlay {
        opacity: 1;
    }

    .cta-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .cta-buttons .animate-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .cta-buttons .animate-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .empty-state {
        padding: 3rem 0;
    }

    .empty-state i {
        margin-bottom: 1rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Animation du scroll indicator
    const scrollIndicator = document.querySelector('.hero-scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', function() {
            const nextSection = document.querySelector('.py-5');
            if (nextSection) {
                nextSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    // Effet de parallaxe sur le hero
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});
</script>
@endpush 