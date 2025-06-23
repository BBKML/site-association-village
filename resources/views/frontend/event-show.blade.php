@extends('layouts.app')

@section('title', $event->title . ' - Association du Village')

@section('content')
    <!-- Event Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('events') }}">Événements</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
                        </ol>
                    </nav>

                    <!-- Event -->
                    <article class="card">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                        @endif
                        <div class="card-body">
                            <h1 class="card-title">{{ $event->title }}</h1>
                            <div class="d-flex align-items-center mb-3">
                                <small class="text-muted me-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $event->date->format('d/m/Y à H:i') }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $event->location }}
                                </small>
                            </div>
                            <div class="card-text">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </article>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('events') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour aux événements
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="fas fa-share me-1"></i>
                                Partager
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 