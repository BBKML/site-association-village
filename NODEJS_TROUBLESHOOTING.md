# 🟢 Guide de Dépannage Node.js - Déploiement Render

Ce guide spécifique vous aide à résoudre les problèmes liés à Node.js et npm lors du déploiement.

## ❌ Erreur "npm: not found"

### Problème
```
/bin/sh: 1: npm: not found
error: failed to solve: process "/bin/sh -c if [ -f \"package.json\"]; then npm install && npm run build; fi" did not complete successfully: exit code: 127
```

### Solution
Utilisez `Dockerfile.robust` qui installe Node.js 20 correctement.

## ❌ Erreur "Unsupported engine"

### Problème
```
npm error code EBADENGINE
npm error engine Unsupported engine
npm error engine Not compatible with your version of node/npm: npm@11.4.2
npm error notsup Required: {"node":"^20.17.0 || >=22.9.0"}
npm error notsup Actual:   {"npm":"10.8.2","node":"v18.20.8"}
```

### Cause
- Node.js 18 installé mais npm@latest nécessite Node.js 20+
- Conflit de versions entre Node.js et npm

### Solutions

#### Solution 1: Utiliser Node.js 20 (Recommandé)
```dockerfile
# Installer Node.js 20 et npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
```

#### Solution 2: Ne pas mettre à jour npm
```dockerfile
# Installer Node.js 18 avec npm par défaut
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
# Ne pas ajouter: npm install -g npm@latest
```

#### Solution 3: Utiliser une version spécifique de npm
```dockerfile
# Installer Node.js 18 avec npm compatible
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@10.8.2
```

## 🔧 Versions Compatibles

### Node.js 18.x
- ✅ npm 8.x - 10.x
- ❌ npm 11.x+ (nécessite Node.js 20+)

### Node.js 20.x
- ✅ npm 8.x - 11.x+
- ✅ Toutes les versions récentes

### Node.js 22.x
- ✅ npm 8.x - 11.x+
- ✅ Versions les plus récentes

## 📋 Dockerfiles Disponibles

### Dockerfile.robust (Recommandé)
```dockerfile
# Installer Node.js 20 de manière robuste
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
```

**Avantages :**
- ✅ Node.js 20 (version LTS)
- ✅ npm compatible
- ✅ Installation robuste
- ✅ Nettoyage automatique

### Dockerfile.simple
```dockerfile
# Installer Node.js 20 et npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
```

### Dockerfile.production
```dockerfile
# Pas de Node.js - pré-compilation locale requise
```

## 🚀 Configuration Recommandée

### Dans render.yaml
```yaml
dockerfilePath: ./Dockerfile.robust
```

### Variables d'environnement
```env
NODE_ENV=production
NPM_CONFIG_PRODUCTION=true
```

## 🔍 Vérification

### Tester localement
```bash
# Construire l'image
docker build -f Dockerfile.robust -t laravel-test .

# Vérifier Node.js et npm
docker run --rm laravel-test node --version
docker run --rm laravel-test npm --version
```

### Script de vérification
```bash
./quick-check.sh
```

## 🛠️ Dépannage Avancé

### Problème de cache npm
```dockerfile
# Nettoyer le cache npm
RUN npm cache clean --force
```

### Problème de permissions
```dockerfile
# Créer un utilisateur npm
RUN adduser --disabled-password --gecos "" npmuser
USER npmuser
```

### Problème de réseau
```dockerfile
# Utiliser un registry npm spécifique
RUN npm config set registry https://registry.npmjs.org/
```

## 📊 Comparaison des Approches

| Approche | Node.js | npm | Stabilité | Taille |
|----------|---------|-----|-----------|--------|
| Dockerfile.robust | 20.x | Compatible | ⭐⭐⭐⭐⭐ | Moyenne |
| Dockerfile.simple | 20.x | Compatible | ⭐⭐⭐⭐ | Moyenne |
| Dockerfile.production | Aucun | Aucun | ⭐⭐⭐⭐⭐ | Petite |
| Node.js 18 | 18.x | Limité | ⭐⭐⭐ | Moyenne |

## 🎯 Recommandation Finale

**Utilisez `Dockerfile.robust`** car il :
- ✅ Installe Node.js 20 (LTS)
- ✅ Évite les conflits de version
- ✅ Inclut une gestion d'erreur robuste
- ✅ Nettoie automatiquement les caches

---

**💡 Conseil** : Si vous continuez à avoir des problèmes, considérez l'approche de pré-compilation locale avec `Dockerfile.production`. 