<?php
declare(strict_types=1);

// Error reporting (disable in production)
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
    ini_set('session.use_strict_mode', '1');
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root'); // Change in production
define('DB_PASS', ''); // Change in production
define('DB_CHARSET', 'utf8mb4');

// SMTP Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'astronetgn@gmail.com');
define('SMTP_PASSWORD', 'vfemtvsydyvaesva'); // App password
define('SMTP_FROM_EMAIL', 'astronetgn@gmail.com');
define('SMTP_FROM_NAME', 'Portfolio Contact');

// Site configuration
define('SITE_NAME', 'Elhadj Alhassana CAMARA - Portfolio');
define('SITE_URL', 'http://localhost/php-portfolio'); // Change in production

// Rate limiting
define('RATE_LIMIT_MAX', 5);
define('RATE_LIMIT_WINDOW', 900); // 15 minutes in seconds

// Personal information
define('PERSONAL_INFO', [
    'firstName' => 'Elhadj Alhassana',
    'lastName' => 'CAMARA',
    'title' => 'Développeur Web',
    'phone' => '+224 624 62 94 77',
    'email' => 'astronetgn@gmail.com',
    'location' => 'Guinée',
    'availability' => 'Disponible pour stages et opportunités'
]);

// Database connection function
function getDBConnection(): PDO {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        error_log('Database connection error: ' . $e->getMessage());
        die('Erreur de connexion à la base de données');
    }
}
