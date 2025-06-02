#!/bin/bash
# save-to-github.sh

echo "🚀 SAUVEGARDE SUR GITHUB"
echo "======================="

# 1. Initialiser Git si nécessaire
if [ ! -d ".git" ]; then
    echo "📁 Initialisation de Git..."
    git init
fi

# 2. Ajouter le fichier .gitignore si nécessaire
if [ ! -f ".gitignore" ]; then
    echo "📝 Création du .gitignore..."
    cat > .gitignore << 'EOF'
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
*.log
.DS_Store
Thumbs.db
/backup
*.backup
EOF
fi

# 3. Ajouter tous les fichiers
echo "📂 Ajout des fichiers..."
git add .

# 4. Créer le commit
echo "💾 Création du commit..."
git commit -m "✨ Dashboard moderne avec glassmorphism
- Dashboard superadmin avec analytics
- Dashboard admin école pratique
- Design glassmorphique complet
- Animations et effets visuels
- Conformité Loi 25 Québec"

# 5. Configurer le remote (remplacez par votre URL)
echo "🔗 Configuration du remote..."
echo ""
echo "⚠️  IMPORTANT: Remplacez l'URL ci-dessous par votre repository GitHub"
echo "Exemple: git remote add origin https://github.com/VOTRE-USERNAME/studiosdb.git"
echo ""
read -p "Entrez l'URL de votre repository GitHub: " REPO_URL

if [ ! -z "$REPO_URL" ]; then
    git remote add origin $REPO_URL 2>/dev/null || git remote set-url origin $REPO_URL
fi

# 6. Push vers GitHub
echo "📤 Envoi vers GitHub..."
git branch -M main
git push -u origin main

echo "✅ Sauvegarde terminée !"
