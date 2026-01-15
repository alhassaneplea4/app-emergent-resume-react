# Installation Rapide - Portfolio PHP

## 📋 Checklist Installation (5 minutes)

### Étape 1 : Créer la base de données MySQL

```bash
# Méthode 1 : Via ligne de commande
mysql -u root -p < sql/database.sql

# Méthode 2 : Via phpMyAdmin
# - Créer une base "portfolio_db"
# - Importer le fichier sql/database.sql
```

### Étape 2 : Configurer includes/config.php

```php
// Modifier ces lignes dans includes/config.php :

// Base de données
define('DB_HOST', 'localhost');        // Votre hôte MySQL
define('DB_NAME', 'portfolio_db');     // Nom de la base
define('DB_USER', 'root');             // Votre utilisateur MySQL
define('DB_PASS', '');                 // Votre mot de passe MySQL

// Email SMTP (Gmail)
define('SMTP_USERNAME', 'votre_email@gmail.com');
define('SMTP_PASSWORD', 'votre_mot_de_passe_app'); // Mot de passe d'application Google

// URL du site
define('SITE_URL', 'http://localhost/php-portfolio'); // Votre URL
```

### Étape 3 : Déployer les fichiers

**Option A : Serveur local (XAMPP/WAMP/MAMP)**

```bash
# Copier le dossier php-portfolio dans :
# - XAMPP : C:/xampp/htdocs/php-portfolio
# - WAMP : C:/wamp64/www/php-portfolio
# - MAMP : /Applications/MAMP/htdocs/php-portfolio
```

**Option B : Serveur Linux**

```bash
# Copier vers le répertoire web
sudo cp -r php-portfolio /var/www/html/

# Définir les permissions
sudo chown -R www-data:www-data /var/www/html/php-portfolio
sudo chmod -R 755 /var/www/html/php-portfolio
sudo chmod 600 /var/www/html/php-portfolio/includes/config.php
```

### Étape 4 : Tester le site

Ouvrir dans le navigateur :
- Local : `http://localhost/php-portfolio/`
- Serveur : `http://votre-domaine.com/`

### Étape 5 : Tester le formulaire de contact

1. Aller sur la page Contact
2. Remplir le formulaire
3. Vérifier que le message est enregistré :

```sql
USE portfolio_db;
SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5;
```

## ⚡ Problèmes courants

### ❌ Erreur "Connection refused"
**Solution** : Vérifier DB_HOST, DB_USER, DB_PASS dans config.php

### ❌ Page blanche
**Solution** : 
```bash
# Activer les erreurs temporairement dans config.php
ini_set('display_errors', '1');
error_reporting(E_ALL);
```

### ❌ Email ne part pas
**Solutions** :
1. Vérifier SMTP_USERNAME et SMTP_PASSWORD
2. Générer un nouveau mot de passe d'application Google
3. Vérifier les logs : `/var/log/apache2/error.log` ou `/var/log/php-error.log`

### ❌ CSS/JS ne charge pas
**Solution** : Vérifier les chemins dans includes/header.php et footer.php

## 🔒 Sécurité Production

Avant de mettre en production :

```php
// Dans includes/config.php, ligne 5-10
// Désactiver les erreurs :
ini_set('display_errors', '0');
error_reporting(0);
```

```bash
# Définir les bonnes permissions
chmod 644 *.php
chmod 644 includes/*.php
chmod 755 assets/css assets/js assets/img
chmod 600 includes/config.php
```

## 📧 Configuration Email Gmail

1. Aller sur : https://myaccount.google.com/security
2. Activer "Validation en 2 étapes"
3. Aller sur : https://myaccount.google.com/apppasswords
4. Créer un mot de passe d'application pour "Portfolio"
5. Copier le mot de passe (16 caractères) dans config.php

## ✅ Test Final

Vérifier que tout fonctionne :

- [ ] Page d'accueil charge avec le carousel
- [ ] Navigation entre les pages fonctionne
- [ ] Mode sombre/clair fonctionne
- [ ] Formulaire de contact envoie et enregistre
- [ ] Email de notification est reçu (optionnel)
- [ ] Pas d'erreurs dans la console navigateur (F12)

## 🚀 Déploiement cPanel

1. Compresser le dossier `php-portfolio` en ZIP
2. Se connecter à cPanel
3. Aller dans "Gestionnaire de fichiers"
4. Uploader le ZIP dans `public_html/`
5. Extraire le ZIP
6. Créer la base de données via "MySQL Databases"
7. Importer `sql/database.sql` via phpMyAdmin
8. Modifier `includes/config.php` avec les infos cPanel
9. Définir les permissions des fichiers

**Bravo ! Votre portfolio est en ligne ! 🎉**
