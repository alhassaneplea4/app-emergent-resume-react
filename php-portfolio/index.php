<?php
declare(strict_types=1);
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Accueil - ' . SITE_NAME;
include 'includes/header.php';
?>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=1920&q=80" class="d-block w-100 carousel-img" alt="Slide 1">
            <div class="carousel-caption-custom">
                <div class="container">
                    <h1 class="display-3 fw-bold">Développeur Web Créatif</h1>
                    <p class="lead">Transformons vos idées en réalité numérique</p>
                    <p>Solutions web modernes et performantes</p>
                    <div class="mt-4">
                        <a href="projects.php" class="btn btn-primary btn-lg me-2">Voir mes projets</a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg">Me contacter</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1487058792275-0ad4aaf24ca7?w=1920&q=80" class="d-block w-100 carousel-img" alt="Slide 2">
            <div class="carousel-caption-custom">
                <div class="container">
                    <h1 class="display-3 fw-bold">Solutions Numériques</h1>
                    <p class="lead">De la conception à la maintenance</p>
                    <p>Expertise complète en développement et support</p>
                    <div class="mt-4">
                        <a href="projects.php" class="btn btn-primary btn-lg me-2">Voir mes projets</a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg">Me contacter</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1920&q=80" class="d-block w-100 carousel-img" alt="Slide 3">
            <div class="carousel-caption-custom">
                <div class="container">
                    <h1 class="display-3 fw-bold">Maintenance & Support</h1>
                    <p class="lead">Votre partenaire informatique de confiance</p>
                    <p>Configuration, maintenance et optimisation</p>
                    <div class="mt-4">
                        <a href="projects.php" class="btn btn-primary btn-lg me-2">Voir mes projets</a>
                        <a href="contact.php" class="btn btn-outline-light btn-lg">Me contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Mes Services</h2>
            <p class="lead text-muted">Des solutions complètes pour tous vos besoins numériques</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-3 mb-3 d-inline-block">
                            <i class="bi bi-code-slash fs-3"></i>
                        </div>
                        <h3 class="h4 mb-3">Développement Web</h3>
                        <p class="text-muted">Création de sites web modernes, responsive et performants avec les dernières technologies (HTML5, CSS3, JavaScript, PHP, React).</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-3 mb-3 d-inline-block">
                            <i class="bi bi-tools fs-3"></i>
                        </div>
                        <h3 class="h4 mb-3">Maintenance Informatique</h3>
                        <p class="text-muted">Configuration, maintenance et support technique pour ordinateurs et systèmes. Diagnostic et résolution de problèmes matériels et logiciels.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-3 mb-3 d-inline-block">
                            <i class="bi bi-palette fs-3"></i>
                        </div>
                        <h3 class="h4 mb-3">Infographie & Design</h3>
                        <p class="text-muted">Création de visuels professionnels, design UI/UX et identité visuelle pour donner vie à vos projets numériques.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-3">Prêt à démarrer votre projet ?</h2>
        <p class="lead mb-4">Je suis disponible pour des stages et opportunités professionnelles. Discutons de votre projet !</p>
        <a href="contact.php" class="btn btn-light btn-lg">Me contacter maintenant</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
