#!/bin/bash

# Script de démarrage pour Laravel sur Render

set -e

echo "🚀 Démarrage de l'application Laravel..."

# Générer la clé d'application si elle n'existe pas
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "🔑 Génération de la clé d'application..."
    php artisan key:generate --force
fi

# Exécuter les migrations si la base de données est configurée
if [ -n "$DB_HOST" ] && [ -n "$DB_DATABASE" ]; then
    echo "🗃️ Exécution des migrations..."
    php artisan migrate --force || echo "⚠️ Erreur lors des migrations, continuation..."
fi

# Vider et recréer le cache
echo "🧹 Nettoyage du cache..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Optimiser l'application
echo "⚡ Optimisation de l'application..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Démarrer Supervisor
echo "🎯 Démarrage de Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf 