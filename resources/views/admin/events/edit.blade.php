@extends('layouts.admin')

@section('title', 'Modifier l\'Événement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Modifier l'événement : {{ $event->title }}</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date et heure</label>
                        <input type="datetime-local" class="form-control" id="date" name="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="upcoming" @selected(old('status', $event->status) == 'upcoming')>À venir</option>
                            <option value="ongoing" @selected(old('status', $event->status) == 'ongoing')>En cours</option>
                            <option value="completed" @selected(old('status', $event->status) == 'completed')>Terminé</option>
                            <option value="cancelled" @selected(old('status', $event->status) == 'cancelled')>Annulé</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="max_participants" class="form-label">Participants max (optionnel)</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" min="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if($event->image)
                        <div class="mt-2">
                            <small>Image actuelle :</small>
                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="img-thumbnail mt-1" style="max-height: 100px;">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Mettre à jour l'événement
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 