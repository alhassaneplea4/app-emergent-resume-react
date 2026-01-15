<?php
declare(strict_types=1);
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Projets - ' . SITE_NAME;
include 'includes/header.php';

// Projects data
$projects = [
    [
        'id' => 1,
        'title' => 'Plateforme E-Commerce',
        'description' => 'Développement d\'une plateforme de commerce en ligne complète avec système de paiement sécurisé, gestion des stocks et interface administrateur.',
        'technologies' => ['PHP', 'MySQL', 'Bootstrap', 'JavaScript'],
        'category' => 'Web',
        'image' => 'https://images.unsplash.com/photo-1557821552-17105176677c?w=800&q=80'
    ],
    [
        'id' => 2,
        'title' => 'Application de Gestion',
        'description' => 'Système de gestion pour entreprises incluant gestion clients, facturation automatique, rapports et tableaux de bord analytiques.',
        'technologies' => ['React', 'FastAPI', 'MongoDB'],
        'category' => 'Web',
        'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&q=80'
    ],
    [
        'id' => 3,
        'title' => 'Site Vitrine Responsive',
        'description' => 'Conception et développement d\'un site vitrine moderne avec animations fluides, optimisé pour tous les appareils et conforme aux standards SEO.',
        'technologies' => ['HTML5', 'CSS3', 'JavaScript', 'Bootstrap'],
        'category' => 'Design',
        'image' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=800&q=80'
    ],
    [
        'id' => 4,
        'title' => 'Maintenance Parc Informatique',
        'description' => 'Configuration et maintenance complète d\'un parc informatique de 50+ machines, incluant installation systèmes, sécurisation réseau et support utilisateurs.',
        'technologies' => ['Windows Server', 'Linux', 'Réseau', 'Sécurité'],
        'category' => 'Maintenance',
        'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80'
    ]
];

$categories = array_unique(array_column($projects, 'category'));
array_unshift($categories, 'All');

$filter = $_GET['filter'] ?? 'All';
$filtered_projects = $filter === 'All' ? $projects : array_filter($projects, fn($p) => $p['category'] === $filter);
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Mes Projets</h1>
        <p class="lead text-muted">Découvrez mes réalisations en développement web, design et maintenance informatique</p>
    </div>

    <!-- Filter Buttons -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <span class="text-muted me-2">
            <i class="bi bi-funnel"></i> Filtrer par :
        </span>
        <?php foreach ($categories as $cat): ?>
        <a href="?filter=<?= urlencode($cat) ?>" 
           class="btn btn-sm <?= $filter === $cat ? 'btn-primary' : 'btn-outline-primary' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Projects Grid -->
    <div class="row g-4">
        <?php if (count($filtered_projects) > 0): ?>
            <?php foreach ($filtered_projects as $project): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="position-relative overflow-hidden">
                        <img src="<?= htmlspecialchars($project['image']) ?>" 
                             class="card-img-top project-img" 
                             alt="<?= htmlspecialchars($project['title']) ?>"
                             loading="lazy">
                        <div class="project-overlay">
                            <a href="#" class="btn btn-light">
                                <i class="bi bi-arrow-up-right me-2"></i>Voir le projet
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-primary mb-2"><?= htmlspecialchars($project['category']) ?></span>
                        <h3 class="h5 card-title"><?= htmlspecialchars($project['title']) ?></h3>
                        <p class="card-text text-muted small"><?= htmlspecialchars($project['description']) ?></p>
                        <div class="d-flex flex-wrap gap-1 mt-3">
                            <?php foreach ($project['technologies'] as $tech): ?>
                            <span class="badge bg-light text-dark border"><?= htmlspecialchars($tech) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Aucun projet trouvé dans cette catégorie.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
