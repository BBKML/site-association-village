# 🏘️ Site Web Association du Village

Un site web moderne et responsive développé avec Laravel pour l'association du village, permettant la gestion de contenu, la communication avec les habitants et la valorisation du patrimoine local.

## 📋 Fonctionnalités

### Frontend (Site Public)
- **Page d'accueil** : Présentation de l'association, actualités récentes, événements à venir
- **Actualités** : Articles avec catégorisation et système de publication
- **Événements** : Calendrier d'événements avec gestion des dates et lieux
- **Galerie photos** : Partage de photos du village et des activités
- **Services locaux** : Annuaire des commerçants, artisans et services
- **Équipe** : Présentation des membres du bureau
- **Contact** : Formulaire de contact et informations de l'association
- **Newsletter** : Système d'abonnement pour rester informé

### Backend (Administration)
- **Tableau de bord** : Statistiques et aperçu des activités
- **Gestion des articles** : CRUD complet avec éditeur de contenu
- **Gestion des événements** : Planification et organisation
- **Gestion des photos** : Upload et organisation de la galerie
- **Gestion des services** : Annuaire des services locaux
- **Gestion de l'équipe** : Membres du bureau
- **Pages statiques** : Contenu éditable (À propos, Histoire, etc.)
- **Paramètres** : Configuration du site

## 🛠️ Technologies Utilisées

- **Backend** : Laravel 12.x
- **Frontend** : Bootstrap 5, Font Awesome
- **Base de données** : SQLite (développement) / MySQL (production)
- **Authentification** : Laravel Auth
- **Responsive Design** : Mobile-first approach

## 📦 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js (optionnel pour les assets)

### Étapes d'installation

1. **Cloner le projet**
```bash
git clone [url-du-repo]
cd site-association-village
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
```bash
# Modifier .env pour configurer la base de données
DB_CONNECTION=sqlite
DB_DATABASE=/chemin/vers/database.sqlite
```

5. **Créer la base de données et migrer**
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

6. **Créer le lien symbolique pour le stockage**
```bash
php artisan storage:link
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

## 🔐 Accès Administration

- **URL** : `http://localhost:8000/login`
- **Email** : `admin@association-village.ci`
- **Mot de passe** : `password`

## 📁 Structure du Projet

```
site-association-village/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Contrôleurs d'administration
│   │   └── Frontend/       # Contrôleurs du site public
│   └── Models/             # Modèles Eloquent
├── database/
│   ├── migrations/         # Migrations de base de données
│   └── seeders/           # Seeders pour les données de test
├── resources/
│   └── views/
│       ├── admin/         # Vues d'administration
│       ├── frontend/      # Vues du site public
│       ├── layouts/       # Layouts principaux
│       └── components/    # Composants réutilisables
└── routes/
    └── web.php           # Routes de l'application
```

## 🗄️ Base de Données

### Tables principales
- `users` : Utilisateurs du système
- `roles` : Rôles et permissions
- `articles` : Articles et actualités
- `categories` : Catégories d'articles
- `events` : Événements du village
- `photos` : Galerie photos
- `services` : Services locaux
- `teams` : Membres de l'équipe
- `pages` : Pages statiques
- `contacts` : Messages de contact
- `newsletter_subscribers` : Abonnés newsletter
- `settings` : Paramètres du site

## 🎨 Personnalisation

### Couleurs
Les couleurs principales sont définies dans les fichiers CSS :
- Couleur primaire : `#8B4513` (Marron)
- Couleur secondaire : `#D2691E` (Orange)
- Couleur d'accent : `#F4A460` (Sable)

### Typographie
- Police principale : Open Sans
- Police des titres : Roboto

## 📱 Responsive Design

Le site est entièrement responsive avec des breakpoints :
- Mobile : < 768px
- Tablette : 768px - 1024px
- Desktop : > 1024px

## 🔧 Configuration

### Paramètres du site
Les paramètres sont stockés dans la table `settings` :
- Nom du site
- Description
- Coordonnées de contact
- Liens réseaux sociaux

### Gestion des médias
- Upload d'images via le système de stockage Laravel
- Redimensionnement automatique des images
- Organisation par dossiers

## 🚀 Déploiement

### Production
1. Configurer la base de données MySQL
2. Optimiser l'application : `php artisan config:cache`
3. Configurer le serveur web (Apache/Nginx)
4. Configurer SSL pour la sécurité

### Hébergement recommandé
- Hébergement mutualisé compatible PHP 8.2+
- Base de données MySQL
- Certificat SSL
- Sauvegarde automatique

## 📊 Maintenance

### Sauvegardes
- Base de données : Quotidienne
- Fichiers uploadés : Hebdomadaire
- Code source : Via Git

### Mises à jour
- Laravel : Suivre les versions LTS
- Dépendances : `composer update`
- Sécurité : Surveiller les vulnérabilités

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature
3. Commiter les changements
4. Pousser vers la branche
5. Créer une Pull Request

## 📄 Licence

Ce projet est développé pour l'Association du Village. Tous droits réservés.

## 📞 Support

Pour toute question ou support :
- Email : contact@association-village.ci
- Téléphone : +225 27 22 49 74 84

---

**Développé avec ❤️ pour l'Association du Village**
