# 🚀 Guide de Déploiement Laravel sur Render

Ce guide vous accompagne pour déployer votre application Laravel sur Render.com en utilisant Docker.

## 📋 Prérequis

- ✅ Compte Render.com
- ✅ Application Laravel dans un dépôt Git (GitHub/GitLab)
- ✅ Base de données (MySQL/PostgreSQL)
- ✅ Docker installé en local (optionnel, pour tests)

## 🗂️ Structure des fichiers créés

```
site-association-village/
├── Dockerfile                 # Configuration Docker
├── render.yaml               # Configuration Render
├── .renderignore             # Fichiers à ignorer
├── docker/
│   ├── nginx.conf           # Configuration Nginx
│   ├── supervisord.conf     # Configuration Supervisor
│   └── start.sh             # Script de démarrage
└── DEPLOYMENT_GUIDE.md      # Ce guide
```

## 🔧 Configuration de la Base de Données

### Option 1: Base de données Render (Recommandé)

1. Dans votre dashboard Render, créez une nouvelle **PostgreSQL Database**
2. Notez les informations de connexion :
   - **Host**: `your-db-host.render.com`
   - **Port**: `5432`
   - **Database**: `your-db-name`
   - **Username**: `your-username`
   - **Password**: `your-password`

### Option 2: Base de données externe

Vous pouvez utiliser :
- **PlanetScale** (MySQL)
- **Railway** (PostgreSQL/MySQL)
- **Supabase** (PostgreSQL)
- **Votre propre serveur**

## 🌐 Déploiement sur Render

### Étape 1: Connecter votre dépôt

1. Connectez-vous à [Render.com](https://render.com)
2. Cliquez sur **"New +"** → **"Web Service"**
3. Connectez votre dépôt GitHub/GitLab
4. Sélectionnez le dépôt contenant votre application Laravel

### Étape 2: Configuration du service

1. **Name**: `site-association-village` (ou votre nom)
2. **Environment**: `Docker`
3. **Region**: Choisissez la région la plus proche
4. **Branch**: `main` (ou votre branche principale)
5. **Root Directory**: `site-association-village` (si votre app est dans un sous-dossier)

### Étape 3: Variables d'environnement

Configurez ces variables dans l'interface Render :

#### Variables de base
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-app.onrender.com
```

#### Base de données
```
DB_CONNECTION=mysql
DB_HOST=votre-host-mysql
DB_PORT=3306
DB_DATABASE=votre-nom-bd
DB_USERNAME=votre-utilisateur
DB_PASSWORD=votre-mot-de-passe
```

#### Cache et Sessions
```
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### Email (optionnel)
```
MAIL_MAILER=smtp
MAIL_HOST=votre-smtp-host
MAIL_PORT=587
MAIL_USERNAME=votre-email
MAIL_PASSWORD=votre-mot-de-passe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@votre-domaine.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Étape 4: Déploiement automatique

1. Activez **"Auto-Deploy"**
2. Cliquez sur **"Create Web Service"**
3. Render va automatiquement :
   - Construire l'image Docker
   - Installer les dépendances
   - Exécuter les migrations
   - Démarrer l'application

## 🔍 Vérification du déploiement

### Logs de déploiement

1. Dans votre dashboard Render, allez dans **"Logs"**
2. Vérifiez que :
   - ✅ Les dépendances sont installées
   - ✅ Les migrations s'exécutent
   - ✅ L'application démarre
   - ✅ Nginx et PHP-FPM fonctionnent

### Test de l'application

1. Visitez votre URL Render
2. Vérifiez que :
   - ✅ La page d'accueil s'affiche
   - ✅ Les routes fonctionnent
   - ✅ La base de données est connectée
   - ✅ Les images se chargent

## 🛠️ Dépannage

### Problèmes courants

#### 1. Erreur "APP_KEY not set"
```
php artisan key:generate
```

#### 2. Erreur de permissions
```bash
chmod -R 755 storage bootstrap/cache
```

#### 3. Erreur de base de données
- Vérifiez les variables d'environnement
- Testez la connexion depuis Render
- Vérifiez que la base de données est accessible

#### 4. Erreur 502 Bad Gateway
- Vérifiez les logs Nginx
- Vérifiez que PHP-FPM démarre
- Vérifiez la configuration Supervisor

### Commandes utiles

```bash
# Voir les logs en temps réel
tail -f /var/log/nginx/error.log

# Tester la configuration Nginx
nginx -t

# Redémarrer les services
supervisorctl restart all
```

## 🔒 Sécurité

### Variables sensibles
- ✅ Ne jamais commiter `.env`
- ✅ Utiliser les variables d'environnement Render
- ✅ Changer les mots de passe par défaut

### Headers de sécurité
Le fichier `nginx.conf` inclut déjà :
- X-Frame-Options
- X-XSS-Protection
- X-Content-Type-Options
- Content-Security-Policy

## 📈 Optimisation

### Performance
- ✅ Cache configuré
- ✅ Gzip activé
- ✅ Images optimisées
- ✅ CDN pour les assets (optionnel)

### Monitoring
- ✅ Logs centralisés
- ✅ Health checks
- ✅ Métriques Render

## 🔄 Mises à jour

### Déploiement automatique
1. Poussez vos changements sur Git
2. Render déploiera automatiquement
3. Vérifiez les logs de déploiement

### Déploiement manuel
1. Dans Render, cliquez sur **"Manual Deploy"**
2. Sélectionnez la branche/commit
3. Cliquez sur **"Deploy latest commit"**

## 📞 Support

En cas de problème :
1. Vérifiez les logs Render
2. Consultez la documentation Laravel
3. Contactez le support Render si nécessaire

---

**🎉 Félicitations !** Votre application Laravel est maintenant déployée sur Render ! 