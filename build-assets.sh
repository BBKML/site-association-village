#!/bin/bash

# Script pour pré-compiler les assets avant le déploiement

echo "🔨 Pré-compilation des assets..."

# Vérifier si Node.js est installé
if ! command -v node &> /dev/null; then
    echo "❌ Node.js n'est pas installé. Veuillez l'installer d'abord."
    echo "📥 Téléchargez depuis: https://nodejs.org/"
    exit 1
fi

# Vérifier si npm est installé
if ! command -v npm &> /dev/null; then
    echo "❌ npm n'est pas installé. Veuillez l'installer d'abord."
    exit 1
fi

echo "✅ Node.js et npm détectés"

# Installer les dépendances
echo "📦 Installation des dépendances..."
npm install

# Construire les assets
echo "🏗️ Construction des assets..."
npm run build

echo "✅ Assets pré-compilés avec succès !"
echo "🚀 Vous pouvez maintenant déployer avec Dockerfile.production" 