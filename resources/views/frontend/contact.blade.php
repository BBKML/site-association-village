@extends('layouts.app')

@section('title', 'Contact - Association du Village')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Contactez-Nous</h1>
            <p class="lead">Nous sommes là pour vous écouter et répondre à vos questions</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Informations de contact -->
                <div class="col-lg-4 mb-5">
                    <h3 class="mb-4">Nos Coordonnées</h3>
                    
                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Adresse</h5>
                            <p>123 Rue du Village<br>12345 Nom du Village<br>Côte d'Ivoire</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-phone fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Téléphone</h5>
                            <p>+225 27 22 49 74 84</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Email</h5>
                            <p>contact@association-village.ci</p>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Horaires</h5>
                            <p>Lundi - Vendredi: 8h - 17h<br>Samedi: 9h - 12h</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Suivez-nous</h5>
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline-primary me-2"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de contact -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Envoyez-nous un message</h3>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" class="js-validate" id="contact-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom complet *</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" required 
                                                   data-min-length="2" data-max-length="100">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Téléphone</label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                                   data-min-length="8">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Sujet *</label>
                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                                   id="subject" name="subject" value="{{ old('subject') }}" required 
                                                   data-min-length="5" data-max-length="200">
                                            @error('subject')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" required 
                                              data-min-length="10" data-max-length="2000">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Champ honeypot anti-spam (caché) -->
                                <div class="d-none">
                                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                                </div>
                                
                                <!-- CAPTCHA -->
                                <div class="mb-3">
                                    <label for="captcha" class="form-label">Code de sécurité *</label>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="captcha-container">
                                                {!! captcha_img() !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('captcha') is-invalid @enderror" 
                                                   id="captcha" name="captcha" placeholder="Entrez le code ci-dessus" required>
                                            @error('captcha')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Messages d'erreur généraux -->
                                @error('spam')
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                    </div>
                                @enderror
                                
                                @error('speed')
                                    <div class="alert alert-warning">
                                        <i class="fas fa-clock"></i> {{ $message }}
                                    </div>
                                @enderror
                                
                                @error('general')
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane"></i> Envoyer le message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carte -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-4">Notre Localisation</h3>
                    <div class="ratio ratio-21x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.5!2d-4.0!3d5.3!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNcKwMTgnMDAuMCJOIDTCsDAwJzAwLjAiVw!5e0!3m2!1sfr!2sci!4v1234567890" 
                                style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
// Fonction pour actualiser le CAPTCHA
function refreshCaptcha() {
    fetch('{{ route("captcha.refresh") }}')
        .then(response => response.text())
        .then(html => {
            document.querySelector('.captcha-container').innerHTML = html +
                `<button type=\"button\" class=\"btn btn-sm btn-outline-secondary ms-2\" onclick=\"refreshCaptcha()\">`
                + `<i class=\"fas fa-sync-alt\"></i> Actualiser</button>`;
        })
        .catch(error => {
            console.error('Erreur lors de l\'actualisation du CAPTCHA:', error);
        });
}

// Validation personnalisée pour le formulaire de contact
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    if (form) {
        const validator = new FormValidator('#contact-form', {
            showErrors: true,
            realTime: true
        });
        
        // Validation personnalisée pour le téléphone
        const phoneField = document.getElementById('phone');
        if (phoneField) {
            phoneField.addEventListener('input', function() {
                const value = this.value.trim();
                if (value && !this.isValidPhone(value)) {
                    this.classList.add('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback') || 
                                   document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Veuillez entrer un numéro de téléphone valide.';
                    if (!this.parentNode.querySelector('.invalid-feedback')) {
                        this.parentNode.appendChild(errorDiv);
                    }
                } else {
                    this.classList.remove('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) errorDiv.remove();
                }
            });
        }
        
        // Validation personnalisée pour le message (pas de liens multiples)
        const messageField = document.getElementById('message');
        if (messageField) {
            messageField.addEventListener('input', function() {
                const value = this.value;
                const linkCount = (value.match(/https?:\/\/[^\s]+/g) || []).length;
                
                if (linkCount > 2) {
                    this.classList.add('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback') || 
                                   document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Trop de liens dans le message (maximum 2 autorisés).';
                    if (!this.parentNode.querySelector('.invalid-feedback')) {
                        this.parentNode.appendChild(errorDiv);
                    }
                } else {
                    this.classList.remove('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv && errorDiv.textContent.includes('liens')) {
                        errorDiv.remove();
                    }
                }
            });
        }
    }
});
</script>

<style>
.captcha-container {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
}

.captcha-container img {
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.captcha-container button {
    white-space: nowrap;
}

.invalid-feedback {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border-left: 4px solid #ffc107;
}
</style> 