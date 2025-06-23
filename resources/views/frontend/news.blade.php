@extends('layouts.app')

@section('title', 'Actualités - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Actualités</h1>
            <p class="lead">Restez informé des dernières nouvelles de notre village</p>
        </div>
    </section>

    <!-- Articles Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                @forelse($articles as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ Str::limit($article->content, 150) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $article->published_at->format('d/m/Y') }}</small>
                                    <a href="{{ route('news.show', $article->id) }}" class="btn btn-sm btn-primary">Lire plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Aucune actualité disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection 