#!/bin/bash

# Script de vérification pré-déploiement Laravel sur Render

echo "🔍 Vérification de la configuration de déploiement..."
echo "=================================================="

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Fonction pour vérifier un fichier
check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✅ $1${NC}"
        return 0
    else
        echo -e "${RED}❌ $1 (manquant)${NC}"
        return 1
    fi
}

# Fonction pour vérifier un dossier
check_dir() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✅ $1${NC}"
        return 0
    else
        echo -e "${RED}❌ $1 (manquant)${NC}"
        return 1
    fi
}

# Compteurs
total_checks=0
passed_checks=0

echo ""
echo "📁 Fichiers de configuration Docker :"
echo "-------------------------------------"

((total_checks++))
if check_file "Dockerfile"; then ((passed_checks++)); fi

((total_checks++))
if check_file "render.yaml"; then ((passed_checks++)); fi

((total_checks++))
if check_file ".renderignore"; then ((passed_checks++)); fi

echo ""
echo "📂 Dossier docker et configurations :"
echo "-------------------------------------"

((total_checks++))
if check_dir "docker"; then ((passed_checks++)); fi

((total_checks++))
if check_file "docker/nginx.conf"; then ((passed_checks++)); fi

((total_checks++))
if check_file "docker/supervisord.conf"; then ((passed_checks++)); fi

((total_checks++))
if check_file "docker/start.sh"; then ((passed_checks++)); fi

echo ""
echo "🔧 Configuration Laravel :"
echo "-------------------------"

((total_checks++))
if check_file "composer.json"; then ((passed_checks++)); fi

((total_checks++))
if check_file "artisan"; then ((passed_checks++)); fi

((total_checks++))
if check_dir "config"; then ((passed_checks++)); fi

((total_checks++))
if check_dir "database/migrations"; then ((passed_checks++)); fi

((total_checks++))
if check_dir "public"; then ((passed_checks++)); fi

((total_checks++))
if check_file "public/index.php"; then ((passed_checks++)); fi

echo ""
echo "📋 Documentation :"
echo "-----------------"

((total_checks++))
if check_file "DEPLOYMENT_GUIDE.md"; then ((passed_checks++)); fi

echo ""
echo "🔒 Sécurité :"
echo "-------------"

# Vérifier que .env n'est pas commité
if [ -f ".env" ]; then
    echo -e "${YELLOW}⚠️  .env existe (assurez-vous qu'il n'est pas commité)${NC}"
else
    echo -e "${GREEN}✅ .env n'existe pas (bon pour la sécurité)${NC}"
    ((passed_checks++))
fi
((total_checks++))

# Vérifier les permissions
echo ""
echo "📊 Résumé :"
echo "-----------"
echo -e "Total des vérifications : ${total_checks}"
echo -e "Vérifications réussies : ${GREEN}${passed_checks}${NC}"
echo -e "Vérifications échouées : ${RED}$((total_checks - passed_checks))${NC}"

if [ $passed_checks -eq $total_checks ]; then
    echo ""
    echo -e "${GREEN}🎉 Toutes les vérifications sont passées !${NC}"
    echo -e "${GREEN}Votre application est prête pour le déploiement sur Render.${NC}"
    echo ""
    echo "📝 Prochaines étapes :"
    echo "1. Poussez votre code sur GitHub/GitLab"
    echo "2. Créez un compte sur Render.com"
    echo "3. Connectez votre dépôt"
    echo "4. Configurez les variables d'environnement"
    echo "5. Déployez !"
else
    echo ""
    echo -e "${RED}❌ Certaines vérifications ont échoué.${NC}"
    echo "Veuillez corriger les problèmes avant le déploiement."
fi

echo ""
echo "📖 Consultez DEPLOYMENT_GUIDE.md pour plus d'informations." 