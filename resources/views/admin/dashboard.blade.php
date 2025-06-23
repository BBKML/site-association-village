@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Articles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['articles'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Événements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['events'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Photos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['photos'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-images fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Contacts</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['contacts'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row">
        <!-- Contacts récents -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Contacts Récents</h6>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($recentContacts as $contact)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $contact->name }}</h6>
                                <small class="text-muted">{{ $contact->email }} - {{ $contact->created_at->format('d/m/Y') }}</small>
                                <p class="mb-0 small">{{ Str::limit($contact->subject, 50) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Aucun contact récent</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Événements à venir -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Événements à Venir</h6>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($upcomingEvents as $event)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $event->title }}</h6>
                                <small class="text-muted">{{ $event->date->format('d/m/Y H:i') }} - {{ $event->location }}</small>
                                <p class="mb-0 small">{{ Str::limit($event->description, 50) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Aucun événement à venir</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Articles récents -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Articles Récents</h6>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date de publication</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentArticles as $article)
                                    <tr>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->published_at ? $article->published_at->format('d/m/Y') : 'Non publié' }}</td>
                                        <td>
                                            @if($article->published_at && $article->published_at <= now())
                                                <span class="badge bg-success">Publié</span>
                                            @else
                                                <span class="badge bg-warning">Brouillon</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun article</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Nouvel Article
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Nouvel Événement
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.photos.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-plus me-2"></i>Nouvelle Photo
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.services.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-plus me-2"></i>Nouveau Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 