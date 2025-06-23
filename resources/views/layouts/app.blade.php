<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MUDEZI')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="manifest" href="/images/site.webmanifest">
    <meta name="theme-color" content="#003399">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #003399; /* Bleu foncé du logo */
            --secondary-color: #42A5F5; /* Bleu clair du logo */
            --accent-color: #4CAF50; /* Vert du logo */
            --text-color: #333;
            --light-bg: #F8F9FA;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .navbar-brand {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        /* Navbar fixe avec effet de transparence */
        .navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-nav .nav-link {
            color: var(--text-color) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 51, 153, 0.7), rgba(66, 165, 245, 0.7)), url('/images/village-hero.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0 100px 0; /* Augmenté le padding-top pour compenser la navbar fixe */
            margin-top: 0;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .footer-content {
            position: relative;
            z-index: 1;
        }
        
        .footer-logo {
            transition: transform 0.3s ease;
        }
        
        .footer-logo:hover {
            transform: scale(1.05);
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .newsletter-form {
            position: relative;
        }
        
        .newsletter-form .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .newsletter-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .newsletter-form .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            box-shadow: none;
        }
        
        .newsletter-form .btn {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .newsletter-form .btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        /* Ajustement du contenu principal pour la navbar fixe */
        main {
            padding-top: 0; /* Pas de padding-top car la navbar est fixe */
        }
        
        /* Responsive pour la navbar */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                border-radius: 10px;
                margin-top: 10px;
                padding: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            }
        }
        
        /* Animation pour le bouton hamburger */
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            transition: all 0.3s ease;
        }
        
        /* Effet de survol pour le logo */
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover img {
            transform: scale(1.05);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="/images/logo.png" alt="MUDEZI Logo" style="height: 40px; margin-right: 10px;">
                MUDEZI
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>À Propos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('actions') ? 'active' : '' }}" href="{{ route('actions') }}">
                            <i class="fas fa-hands-helping me-1"></i>Actions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news*') ? 'active' : '' }}" href="{{ route('news') }}">
                            <i class="fas fa-newspaper me-1"></i>Actualités
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('events*') ? 'active' : '' }}" href="{{ route('events') }}">
                            <i class="fas fa-calendar me-1"></i>Événements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">
                            <i class="fas fa-concierge-bell me-1"></i>Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">
                            <i class="fas fa-images me-1"></i>Galerie
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container footer-content">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/images/logo.png" alt="MUDEZI Logo" class="footer-logo me-3" style="height: 50px;">
                        <div>
                            <h5 class="mb-0">MUDEZI</h5>
                            <small class="text-white-50">Association du Village</small>
                        </div>
                    </div>
                    <p class="mb-3">Développement communautaire et préservation du patrimoine local.</p>
                    <div class="social-links">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Liens Rapides</h6>
                    <div class="footer-links">
                        <a href="{{ route('about') }}"><i class="fas fa-chevron-right me-2"></i>À Propos</a>
                        <a href="{{ route('news') }}"><i class="fas fa-chevron-right me-2"></i>Actualités</a>
                        <a href="{{ route('events') }}"><i class="fas fa-chevron-right me-2"></i>Événements</a>
                        <a href="{{ route('services') }}"><i class="fas fa-chevron-right me-2"></i>Services</a>
                        <a href="{{ route('gallery') }}"><i class="fas fa-chevron-right me-2"></i>Galerie</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Contact</h6>
                    <div class="footer-links">
                        <a href="mailto:contact@association-village.ci">
                            <i class="fas fa-envelope me-2"></i>contact@association-village.ci
                        </a>
                        <a href="tel:+2252722497484">
                            <i class="fas fa-phone me-2"></i>+225 27 22 49 74 84
                        </a>
                        <a href="#">
                            <i class="fas fa-map-marker-alt me-2"></i>123 Rue du Village, Côte d'Ivoire
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Newsletter</h6>
                    <p class="small mb-3">Restez informé de nos activités</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Votre email" required>
                            <button type="submit" class="btn btn-outline-light">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} MUDEZI. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <small class="text-white-50">
                        <i class="fas fa-heart text-danger"></i> Fait avec passion pour notre village
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Validation JavaScript -->
    <script src="{{ asset('js/validation.js') }}"></script>
    
    <script>
    // Script pour gérer l'effet de scroll sur la navbar
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        
        // Fonction pour gérer le scroll
        function handleScroll() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        
        // Écouter l'événement scroll
        window.addEventListener('scroll', handleScroll);
        
        // Appeler une fois au chargement pour définir l'état initial
        handleScroll();
        
        // Fermer le menu mobile quand on clique sur un lien
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    });
    </script>
    
    @stack('scripts')
</body>
</html> 