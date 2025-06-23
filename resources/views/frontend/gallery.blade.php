@extends('layouts.app')

@section('title', 'Galerie Photos - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Galerie Photos</h1>
            <p class="lead">Découvrez les moments forts de notre village en images</p>
        </div>
    </section>

    <!-- Galerie Section -->
    <section class="py-5">
        <div class="container">
            <!-- Filtres -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" data-filter="all">Toutes</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="evenements">Événements</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="patrimoine">Patrimoine</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="communaute">Communauté</button>
                            <button type="button" class="btn btn-outline-primary" data-filter="nature">Nature</button>
                        </div>
                    </div>
                </div>
            </div>

            @if($photos->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h4>Aucune photo disponible</h4>
                    <p>La galerie sera bientôt enrichie avec de belles photos de notre village.</p>
                </div>
            @else
                <div class="row g-4" id="gallery-container">
                    @foreach($photos as $photo)
                        <div class="col-lg-4 col-md-6 gallery-item" data-category="{{ $photo->category ?? 'general' }}">
                            <div class="card h-100 shadow-sm gallery-card">
                                <a href="{{ asset('storage/' . $photo->image) }}" 
                                   data-toggle="lightbox" 
                                   data-gallery="gallery"
                                   data-title="{{ $photo->title ?? 'Photo de la galerie' }}"
                                   class="gallery-link">
                                    <div class="gallery-image-container">
                                        <img src="{{ asset('storage/' . $photo->image) }}" 
                                             class="card-img-top gallery-image" 
                                             alt="{{ $photo->title ?? 'Photo de la galerie' }}"
                                             loading="lazy">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    @if($photo->title)
                                        <h5 class="card-title">{{ $photo->title }}</h5>
                                    @endif
                                    @if($photo->description)
                                        <p class="card-text">{{ $photo->description }}</p>
                                    @endif
                                    @if($photo->created_at)
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $photo->created_at->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($photos->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $photos->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Partagez vos photos</h2>
            <p class="lead mb-4">Vous avez des photos de notre village ? Partagez-les avec la communauté !</p>
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-upload me-2"></i>Proposer une photo
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .gallery-card {
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .gallery-image-container {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-overlay {
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
    }

    .gallery-card:hover .gallery-image {
        transform: scale(1.1);
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .gallery-item.show {
        opacity: 1;
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

    .btn-group .btn {
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }

    .btn-group .btn.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bs5-lightbox/1.8.3/index.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée des éléments
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach((item, index) => {
        setTimeout(() => {
            item.classList.add('show');
        }, index * 100);
    });

    // Filtrage des photos
    const filterButtons = document.querySelectorAll('[data-filter]');
    const galleryItems2 = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Mettre à jour les boutons actifs
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrer les photos avec animation
            galleryItems2.forEach(item => {
                const category = item.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.classList.add('show');
                    }, 100);
                } else {
                    item.classList.remove('show');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Lightbox configuration
    if (typeof lightbox !== 'undefined') {
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Photo %1 sur %2'
        });
    }
});
</script>
@endpush
