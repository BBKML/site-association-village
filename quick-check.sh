#!/bin/bash

# Vérification rapide de la configuration Docker

echo "🔍 Vérification rapide de la configuration Docker..."
echo "=================================================="

# Couleurs
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Vérifier le Dockerfile principal
echo ""
echo "📁 Vérification du Dockerfile principal :"

if grep -q "nodejs" Dockerfile; then
    echo -e "${GREEN}✅ Node.js est configuré dans Dockerfile${NC}"
else
    echo -e "${RED}❌ Node.js n'est PAS configuré dans Dockerfile${NC}"
fi

if grep -q "npm install -g npm@latest" Dockerfile; then
    echo -e "${GREEN}✅ npm est configuré dans Dockerfile${NC}"
else
    echo -e "${RED}❌ npm n'est PAS configuré dans Dockerfile${NC}"
fi

# Vérifier le render.yaml
echo ""
echo "📋 Vérification du render.yaml :"

if grep -q "dockerfilePath: ./Dockerfile" render.yaml; then
    echo -e "${GREEN}✅ render.yaml utilise le bon Dockerfile${NC}"
else
    echo -e "${RED}❌ render.yaml n'utilise PAS le bon Dockerfile${NC}"
fi

# Vérifier package.json
echo ""
echo "📦 Vérification du package.json :"

if [ -f "package.json" ]; then
    echo -e "${GREEN}✅ package.json existe${NC}"
    if grep -q "build" package.json; then
        echo -e "${GREEN}✅ Script build trouvé dans package.json${NC}"
    else
        echo -e "${YELLOW}⚠️ Script build non trouvé dans package.json${NC}"
    fi
else
    echo -e "${YELLOW}⚠️ package.json n'existe pas${NC}"
fi

# Vérifier les fichiers de configuration
echo ""
echo "⚙️ Vérification des fichiers de configuration :"

files=("docker/nginx.conf" "docker/supervisord.conf" "docker/start.sh")
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✅ $file existe${NC}"
    else
        echo -e "${RED}❌ $file manquant${NC}"
    fi
done

echo ""
echo "🎯 Résumé :"
echo "Si tous les éléments sont ✅ verts, votre configuration est prête !"
echo "Si vous voyez des ❌ rouges, corrigez-les avant le déploiement."
echo ""
echo "🚀 Prochaines étapes :"
echo "1. git add . && git commit -m 'Fix: Ajout Node.js dans Dockerfile'"
echo "2. git push origin main"
echo "3. Redéployer sur Render" 