<?php
declare(strict_types=1);
if (!defined('DB_HOST')) {
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/functions.php';
}
$current_page = get_current_page();
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio professionnel de <?= PERSONAL_INFO['firstName'] . ' ' . PERSONAL_INFO['lastName'] ?> - <?= PERSONAL_INFO['title'] ?>">
    <meta name="author" content="<?= PERSONAL_INFO['firstName'] . ' ' . PERSONAL_INFO['lastName'] ?>">
    <title><?= $page_title ?? SITE_NAME ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <span class="text-primary"><?= PERSONAL_INFO['firstName'] ?></span>
                <span class="text-dark"><?= PERSONAL_INFO['lastName'] ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('home') ? 'active' : '' ?>" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('about') ? 'active' : '' ?>" href="about.php">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('projects') ? 'active' : '' ?>" href="projects.php">Projets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('contact') ? 'active' : '' ?>" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item ms-2">
                        <button class="btn btn-outline-secondary btn-sm" id="themeToggle" aria-label="Toggle theme">
                            <i class="bi bi-moon-fill" id="themeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <?php
    $flash = get_flash();
    if ($flash):
    ?>
    <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show m-3" role="alert">
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <main>
