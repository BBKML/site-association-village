@extends('layouts.app')

@section('title', $article->title . ' - Association du Village')

@section('content')
    <!-- Article Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('news') }}">Actualités</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
                        </ol>
                    </nav>

                    <!-- Article -->
                    <article class="card">
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                        @endif
                        <div class="card-body">
                            <h1 class="card-title">{{ $article->title }}</h1>
                            <div class="d-flex align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Publié le {{ $article->published_at->format('d/m/Y à H:i') }}
                                </small>
                                @if($article->category)
                                    <small class="text-muted ms-3">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $article->category->name }}
                                    </small>
                                @endif
                            </div>
                            <div class="card-text">
                                {!! nl2br(e($article->content)) !!}
                            </div>
                        </div>
                    </article>

                    <!-- Navigation -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('news') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour aux actualités
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