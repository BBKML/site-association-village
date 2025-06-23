# 🚀 Déploiement Laravel sur Render

Ce projet est configuré pour être déployé automatiquement sur Render.com via Docker.

## 📋 Fichiers de Configuration

### Fichiers principaux
- `Dockerfile` - Configuration Docker pour l'application
- `render.yaml` - Configuration automatique pour Render
- `.renderignore` - Fichiers à exclure du déploiement

### Dossier docker/
- `nginx.conf` - Configuration Nginx optimisée
- `supervisord.conf` - Gestion des processus
- `start.sh` - Script de démarrage personnalisé

## 🎯 Déploiement Rapide

### 1. Préparer le dépôt
```bash
# Vérifier que tous les fichiers sont présents
./check-deployment.sh
```

### 2. Pousser sur Git
```bash
git add .
git commit -m "Configuration déploiement Render"
git push origin main
```

### 3. Déployer sur Render
1. Allez sur [Render.com](https://render.com)
2. Créez un nouveau **Web Service**
3. Connectez votre dépôt GitHub/GitLab
4. Sélectionnez **Docker** comme environnement
5. Configurez les variables d'environnement (voir ci-dessous)

## 🔧 Variables d'Environnement

### Obligatoires
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-app.onrender.com
DB_CONNECTION=mysql
DB_HOST=votre-host-mysql
DB_PORT=3306
DB_DATABASE=votre-nom-bd
DB_USERNAME=votre-utilisateur
DB_PASSWORD=votre-mot-de-passe
```

### Optionnelles
```env
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
MAIL_MAILER=smtp
MAIL_HOST=votre-smtp
MAIL_PORT=587
MAIL_USERNAME=votre-email
MAIL_PASSWORD=votre-mot-de-passe
```

## 🗄️ Base de Données

### Option 1: Render PostgreSQL (Gratuit)
1. Créez une **PostgreSQL Database** sur Render
2. Utilisez les informations de connexion fournies
3. Modifiez `DB_CONNECTION=pgsql` dans les variables

### Option 2: MySQL externe
- **PlanetScale** (MySQL, gratuit)
- **Railway** (MySQL/PostgreSQL)
- **Votre serveur**

## 🔍 Vérification du Déploiement

### Logs Render
1. Dans votre dashboard Render
2. Allez dans **Logs**
3. Vérifiez que :
   - ✅ Les dépendances s'installent
   - ✅ Les migrations s'exécutent
   - ✅ L'application démarre

### Test de l'application
1. Visitez votre URL Render
2. Vérifiez la page d'accueil
3. Testez les fonctionnalités principales

## 🛠️ Dépannage

### Erreurs courantes

#### APP_KEY not set
```bash
# Dans les variables d'environnement Render
APP_KEY=base64:votre-clé-générée
```

#### Erreur 502 Bad Gateway
- Vérifiez les logs Nginx
- Vérifiez que PHP-FPM démarre
- Vérifiez la configuration Supervisor

#### Erreur de base de données
- Vérifiez les variables DB_*
- Testez la connexion
- Vérifiez que la base est accessible

### Commandes utiles
```bash
# Voir les logs en temps réel
tail -f /var/log/nginx/error.log

# Redémarrer les services
supervisorctl restart all

# Tester la configuration
nginx -t
```

## 🔒 Sécurité

### Headers de sécurité inclus
- X-Frame-Options
- X-XSS-Protection
- X-Content-Type-Options
- Content-Security-Policy

### Variables sensibles
- ✅ Ne jamais commiter `.env`
- ✅ Utiliser les variables Render
- ✅ Changer les mots de passe par défaut

## 📈 Optimisations

### Performance
- ✅ Cache configuré
- ✅ Gzip activé
- ✅ Images optimisées
- ✅ Headers de cache

### Monitoring
- ✅ Logs centralisés
- ✅ Health checks
- ✅ Métriques Render

## 🔄 Mises à jour

### Déploiement automatique
1. Poussez sur Git
2. Render déploie automatiquement
3. Vérifiez les logs

### Déploiement manuel
1. Dans Render → **Manual Deploy**
2. Sélectionnez la branche
3. Cliquez **Deploy**

## 📞 Support

- 📖 [Guide complet](DEPLOYMENT_GUIDE.md)
- 🔍 [Script de vérification](check-deployment.sh)
- 🌐 [Documentation Render](https://render.com/docs)
- 📚 [Documentation Laravel](https://laravel.com/docs)

---

**🎉 Votre application Laravel est prête pour Render !** 