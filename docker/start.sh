#!/bin/bash

# Script de démarrage pour Laravel sur Render

set -e

echo "🚀 Démarrage de l'application Laravel..."

# Attendre que la base de données soit prête (si applicable)
if [ -n "$DB_HOST" ]; then
    echo "⏳ Attente de la base de données..."
    while ! nc -z $DB_HOST $DB_PORT; do
        sleep 1
    done
    echo "✅ Base de données prête"
fi

# Générer la clé d'application si elle n'existe pas
if [ -z "$APP_KEY" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate
fi

# Exécuter les migrations
echo "🗃️ Exécution des migrations..."
php artisan migrate --force

# Vider et recréer le cache
echo "🧹 Nettoyage du cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimiser l'application
echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer Supervisor
echo "🎯 Démarrage de Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf 