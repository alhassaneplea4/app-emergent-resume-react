# Portfolio Professionnel - Elhadj Alhassana CAMARA

Portfolio professionnel développé en PHP 8 avec MySQL, Bootstrap 5 et JavaScript.

## Caractéristiques

- ✅ Design moderne et responsive (Bootstrap 5)
- ✅ Mode sombre/clair avec persistance
- ✅ Carousel hero avec 3 slides
- ✅ Formulaire de contact sécurisé
- ✅ Protection XSS, CSRF, SQL Injection
- ✅ Rate limiting (5 requêtes/15 min)
- ✅ Envoi d'email via SMTP
- ✅ Base de données MySQL avec PDO
- ✅ Headers de sécurité OWASP
- ✅ Optimisé pour SEO et performance

## Prérequis

- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur (ou MariaDB)
- Apache 2.4 ou Nginx
- Extension PHP : PDO, PDO_MySQL, mbstring

## Installation

### 1. Configuration de la base de données

```bash
# Se connecter à MySQL
mysql -u root -p

# Exécuter le script SQL
source sql/database.sql
```

Ou importer le fichier `sql/database.sql` via phpMyAdmin.

### 2. Configuration du site

Éditer le fichier `includes/config.php` :

```php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');

// SMTP Configuration (pour l'envoi d'email)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'votre_email@gmail.com');
define('SMTP_PASSWORD', 'votre_mot_de_passe_app');

// Site configuration
define('SITE_URL', 'https://votre-domaine.com');
```

### 3. Configuration Apache

**VirtualHost exemple :**

```apache
<VirtualHost *:80>
    ServerName portfolio.local
    DocumentRoot "/chemin/vers/php-portfolio"
    
    <Directory "/chemin/vers/php-portfolio">
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/portfolio-error.log
    CustomLog ${APACHE_LOG_DIR}/portfolio-access.log combined
</VirtualHost>
```

### 4. Configuration Nginx

**Configuration exemple :**

```nginx
server {
    listen 80;
    server_name portfolio.local;
    root /chemin/vers/php-portfolio;
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ =404;
    }
    
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    }
    
    location ~ /\.(ht|env|sql) {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|css|js|ico|webp)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### 5. Permissions des fichiers

```bash
# Donner les bonnes permissions
chmod 644 *.php
chmod 644 includes/*.php
chmod 755 assets/css assets/js assets/img
chmod 600 includes/config.php
```

## Structure des fichiers

```
php-portfolio/
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── scripts.js
│   └── img/
├── includes/
│   ├── config.php          # Configuration principale
│   ├── functions.php       # Fonctions utilitaires
│   ├── header.php          # Header HTML
│   └── footer.php          # Footer HTML
├── sql/
│   └── database.sql        # Script de création BDD
├── vendor/                 # PHPMailer (optionnel)
├── index.php               # Page d'accueil
├── about.php               # Page À propos
├── projects.php            # Page Projets
├── contact.php             # Page Contact
├── .htaccess               # Configuration Apache
└── README.md               # Ce fichier
```

## Sécurité

### Fonctionnalités de sécurité implémentées

- **Protection XSS** : `htmlspecialchars()` sur toutes les sorties
- **Protection SQL Injection** : Requêtes préparées PDO
- **Protection CSRF** : Token CSRF sur formulaires
- **Rate Limiting** : Limitation 5 requêtes/15 minutes
- **Honeypot** : Champ caché anti-spam
- **Validation serveur** : Vérification stricte des données
- **Headers HTTP** : X-Frame-Options, X-XSS-Protection, etc.
- **Sessions sécurisées** : HttpOnly, Secure (HTTPS)

### Recommandations production

1. **HTTPS** : Activer SSL/TLS (Let's Encrypt gratuit)
2. **Erreurs PHP** : Désactiver `display_errors` en production
3. **Permissions** : Fichiers 644, dossiers 755
4. **Firewall** : Configurer un pare-feu (UFW, iptables)
5. **Mises à jour** : Garder PHP et MySQL à jour
6. **Sauvegardes** : Sauvegarder régulièrement la BDD

## Configuration Email

### Gmail SMTP

1. Activer la validation en 2 étapes sur votre compte Google
2. Générer un mot de passe d'application : https://myaccount.google.com/apppasswords
3. Utiliser ce mot de passe dans `SMTP_PASSWORD`

### Alternative : SendGrid, Mailgun, etc.

Si Gmail pose problème, utiliser un service tiers (plus fiable).

## Tests

### Test formulaire de contact

```bash
# Tester avec curl
curl -X POST http://localhost/php-portfolio/contact.php \
  -d "name=Test User" \
  -d "email=test@example.com" \
  -d "subject=Test" \
  -d "message=Ceci est un test"
```

### Vérifier les messages en base

```sql
USE portfolio_db;
SELECT * FROM contacts ORDER BY created_at DESC;
```

## Performance

### Optimisations implémentées

- Compression GZIP
- Cache navigateur (1 an pour images, 1 mois pour CSS/JS)
- Lazy loading images
- Minification CSS/JS (manuelle)
- Preload fonts

### Lighthouse Score attendu

- Performance : 95+
- Accessibilité : 95+
- Best Practices : 95+
- SEO : 95+

## Support

**Auteur** : Elhadj Alhassana CAMARA  
**Email** : astronetgn@gmail.com  
**Téléphone** : +224 624 62 94 77

## Licence

Ce projet est à usage personnel/professionnel. Tous droits réservés.
