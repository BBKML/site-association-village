@extends('layouts.app')

@section('title', 'Événements - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Événements</h1>
            <p class="lead">Découvrez tous les événements de notre village</p>
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                @forelse($events as $event)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            @if($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $event->date->format('d/m/Y H:i') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $event->location }}
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-primary">Voir détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Aucun événement disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection 