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

if grep -q "setup_20.x" Dockerfile; then
    echo -e "${GREEN}✅ Node.js 20 est configuré dans Dockerfile${NC}"
else
    echo -e "${RED}❌ Node.js 20 n'est PAS configuré dans Dockerfile${NC}"
fi

if grep -q "npm install -g npm@latest" Dockerfile; then
    echo -e "${YELLOW}⚠️ Mise à jour npm détectée (peut causer des conflits)${NC}"
else
    echo -e "${GREEN}✅ Pas de mise à jour npm forcée (bon)${NC}"
fi

# Vérifier Dockerfile.robust
echo ""
echo "🛡️ Vérification du Dockerfile.robust :"

if [ -f "Dockerfile.robust" ]; then
    echo -e "${GREEN}✅ Dockerfile.robust existe${NC}"
    
    if grep -q "setup_20.x" Dockerfile.robust; then
        echo -e "${GREEN}✅ Node.js 20 configuré dans Dockerfile.robust${NC}"
    else
        echo -e "${RED}❌ Node.js 20 non configuré dans Dockerfile.robust${NC}"
    fi
    
    if grep -q "apt-get clean" Dockerfile.robust; then
        echo -e "${GREEN}✅ Nettoyage automatique configuré${NC}"
    else
        echo -e "${YELLOW}⚠️ Nettoyage automatique non configuré${NC}"
    fi
else
    echo -e "${RED}❌ Dockerfile.robust manquant${NC}"
fi

# Vérifier le render.yaml
echo ""
echo "📋 Vérification du render.yaml :"

if grep -q "dockerfilePath: ./Dockerfile.robust" render.yaml; then
    echo -e "${GREEN}✅ render.yaml utilise Dockerfile.robust${NC}"
elif grep -q "dockerfilePath: ./Dockerfile" render.yaml; then
    echo -e "${YELLOW}⚠️ render.yaml utilise Dockerfile principal${NC}"
else
    echo -e "${RED}❌ dockerfilePath non configuré dans render.yaml${NC}"
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

# Vérifier les guides de dépannage
echo ""
echo "📚 Vérification de la documentation :"

docs=("NODEJS_TROUBLESHOOTING.md" "TROUBLESHOOTING.md" "DEPLOYMENT_STRATEGIES.md")
for doc in "${docs[@]}"; do
    if [ -f "$doc" ]; then
        echo -e "${GREEN}✅ $doc existe${NC}"
    else
        echo -e "${YELLOW}⚠️ $doc manquant${NC}"
    fi
done

echo ""
echo "🎯 Résumé :"
echo "Si tous les éléments sont ✅ verts, votre configuration est prête !"
echo "Si vous voyez des ❌ rouges, corrigez-les avant le déploiement."
echo "Si vous voyez des ⚠️ jaunes, considérez les améliorations suggérées."
echo ""
echo "🚀 Prochaines étapes :"
echo "1. git add . && git commit -m 'Fix: Migration vers Node.js 20 et Dockerfile.robust'"
echo "2. git push origin main"
echo "3. Redéployer sur Render"
echo ""
echo "💡 Recommandation : Utilisez Dockerfile.robust pour une installation stable de Node.js 20" 