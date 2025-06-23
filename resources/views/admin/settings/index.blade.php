@extends('layouts.admin')

@section('title', 'Paramètres du Site')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Paramètres du site</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="site_name" class="form-label">
                        Nom du site *
                    </label>
                    <input class="form-control @error('site_name') is-invalid @enderror" 
                           id="site_name" type="text" name="site_name" value="{{ old('site_name', $settings->get('site_name')?->value ?? '') }}" required>
                    @error('site_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="site_description" class="form-label">
                        Description du site
                    </label>
                    <textarea class="form-control @error('site_description') is-invalid @enderror" 
                              id="site_description" name="site_description" rows="3">{{ old('site_description', $settings->get('site_description')?->value ?? '') }}</textarea>
                    @error('site_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="contact_email" class="form-label">
                            Email de contact
                        </label>
                        <input class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings->get('contact_email')?->value ?? '') }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="contact_phone" class="form-label">
                            Téléphone de contact
                        </label>
                        <input class="form-control @error('contact_phone') is-invalid @enderror" 
                               id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings->get('contact_phone')?->value ?? '') }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">
                        Adresse
                    </label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address', $settings->get('address')?->value ?? '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="text-primary mb-3">Réseaux sociaux</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="facebook_url" class="form-label">
                            URL Facebook
                        </label>
                        <input class="form-control @error('facebook_url') is-invalid @enderror" 
                               id="facebook_url" type="url" name="facebook_url" value="{{ old('facebook_url', $settings->get('facebook_url')?->value ?? '') }}">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="twitter_url" class="form-label">
                            URL Twitter
                        </label>
                        <input class="form-control @error('twitter_url') is-invalid @enderror" 
                               id="twitter_url" type="url" name="twitter_url" value="{{ old('twitter_url', $settings->get('twitter_url')?->value ?? '') }}">
                        @error('twitter_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="instagram_url" class="form-label">
                            URL Instagram
                        </label>
                        <input class="form-control @error('instagram_url') is-invalid @enderror" 
                               id="instagram_url" type="url" name="instagram_url" value="{{ old('instagram_url', $settings->get('instagram_url')?->value ?? '') }}">
                        @error('instagram_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="youtube_url" class="form-label">
                            URL YouTube
                        </label>
                        <input class="form-control @error('youtube_url') is-invalid @enderror" 
                               id="youtube_url" type="url" name="youtube_url" value="{{ old('youtube_url', $settings->get('youtube_url')?->value ?? '') }}">
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-2"></i>Sauvegarder les paramètres
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 