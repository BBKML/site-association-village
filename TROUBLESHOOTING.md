# 🛠️ Guide de Dépannage - Déploiement Render

Ce guide vous aide à résoudre les problèmes courants lors du déploiement sur Render.

## ❌ Erreur "failed to solve: process did not complete successfully"

### Problème
```
error: failed to solve: process "/bin/sh -c apt-get update && apt-get install -y ..." did not complete successfully: exit code: 100
```

### Solutions

#### Solution 1: Utiliser le Dockerfile simplifié
Le fichier `Dockerfile.simple` a été créé pour éviter les problèmes de dépendances.

1. Dans votre `render.yaml`, assurez-vous d'utiliser :
   ```yaml
   dockerfilePath: ./Dockerfile.simple
   ```

2. Ou renommez le fichier :
   ```bash
   mv Dockerfile.simple Dockerfile
   ```

#### Solution 2: Vérifier les packages
Si vous utilisez le Dockerfile original, vérifiez que tous les packages sont disponibles :

```dockerfile
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nginx \
    supervisor \
    netcat-openbsd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
```

#### Solution 3: Dockerfile minimal
Si les problèmes persistent, utilisez cette version ultra-simplifiée :

```dockerfile
FROM php:8.2-fpm

# Installer uniquement les dépendances essentielles
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80
CMD ["/usr/local/bin/start.sh"]
```

## ❌ Erreur "APP_KEY not set"

### Solution
Dans les variables d'environnement Render, ajoutez :
```
APP_KEY=base64:VOTRE_CLE_GENEREE
```

Ou laissez Render la générer automatiquement avec :
```yaml
- key: APP_KEY
  generateValue: true
```

## ❌ Erreur de base de données

### Vérifications
1. **Variables d'environnement** :
   ```
   DB_CONNECTION=mysql
   DB_HOST=votre-host
   DB_PORT=3306
   DB_DATABASE=village_association
   DB_USERNAME=votre-utilisateur
   DB_PASSWORD=votre-mot-de-passe
   ```

2. **Connexion à la base** :
   - Vérifiez que la base de données est accessible
   - Testez la connexion depuis Render
   - Vérifiez les permissions utilisateur

## ❌ Erreur 502 Bad Gateway

### Causes possibles
1. **PHP-FPM ne démarre pas**
2. **Nginx mal configuré**
3. **Permissions incorrectes**

### Solutions
1. Vérifiez les logs dans Render
2. Assurez-vous que Supervisor démarre correctement
3. Vérifiez les permissions des dossiers

## ❌ Erreur de permissions

### Solution
Dans le Dockerfile, assurez-vous d'avoir :
```dockerfile
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache
```

## 🔍 Vérification des Logs

### Dans Render
1. Allez dans votre service
2. Cliquez sur **"Logs"**
3. Vérifiez les erreurs en temps réel

### Logs importants à vérifier
- **Build logs** : Erreurs lors de la construction Docker
- **Runtime logs** : Erreurs lors de l'exécution
- **Application logs** : Erreurs Laravel

## 🚀 Déploiement de Test

### Étape 1: Test local (optionnel)
```bash
# Construire l'image localement
docker build -f Dockerfile.simple -t laravel-test .

# Tester l'image
docker run -p 8080:80 laravel-test
```

### Étape 2: Déploiement Render
1. Poussez vos changements sur Git
2. Dans Render, cliquez sur **"Manual Deploy"**
3. Sélectionnez la branche
4. Cliquez sur **"Deploy latest commit"**

## 📞 Support

### Ressources utiles
- [Documentation Render](https://render.com/docs)
- [Documentation Laravel](https://laravel.com/docs)
- [Docker Hub PHP](https://hub.docker.com/_/php)

### En cas de problème persistant
1. Vérifiez que tous les fichiers sont présents
2. Utilisez le script de vérification : `./check-deployment.sh`
3. Consultez les logs Render
4. Contactez le support Render si nécessaire

---

**💡 Conseil** : Commencez toujours par utiliser `Dockerfile.simple` pour éviter les problèmes de dépendances complexes. 