# Dockerfile pour Laravel sur Render

FROM php:8.2-fpm

# Installer les dépendances système
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

# Installer Node.js 20 et npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers du projet
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Installer les dépendances Node.js et construire les assets
RUN if [ -f "package.json" ]; then npm install && npm run build; fi

# Créer le fichier .env s'il n'existe pas
RUN if [ ! -f ".env" ]; then cp .env.example .env; fi

# Donner les permissions appropriées
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Copier la configuration Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copier la configuration Supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copier et rendre exécutable le script de démarrage
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Exposer le port 80
EXPOSE 80

# Utiliser le script de démarrage personnalisé
CMD ["/usr/local/bin/start.sh"] 