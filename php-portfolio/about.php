<?php
declare(strict_types=1);
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'À Propos - ' . SITE_NAME;
include 'includes/header.php';

// CV Data
$cvData = [
    'profile' => [
        'nom' => 'CAMARA',
        'prenom' => 'Elhadj Alhassana',
        'titre' => 'Développeur Web',
        'telephone' => '+224 624 62 94 77',
        'email' => 'astronetgn@gmail.com',
        'localisation' => 'Guinée'
    ],
    'competences' => [
        'Développement Web (HTML, CSS, JavaScript, PHP)',
        'Responsive Design & Bootstrap',
        'Maintenance Informatique',
        'Configuration Systèmes',
        'Infographie & Design',
        'Solutions Numériques Personnalisées'
    ]
];

$skills = [
    ['category' => 'Développement Web', 'items' => ['HTML5', 'CSS3', 'JavaScript ES6+', 'PHP 8', 'Bootstrap 5', 'React']],
    ['category' => 'Backend & Databases', 'items' => ['MySQL', 'PDO', 'MongoDB', 'RESTful APIs']],
    ['category' => 'Maintenance & Systèmes', 'items' => ['Configuration Ordinateurs', 'Maintenance Informatique', 'Support Technique']],
    ['category' => 'Design & Créativité', 'items' => ['Infographie', 'UI/UX Design', 'Adobe Suite', 'Responsive Design']],
    ['category' => 'Outils & Méthodologies', 'items' => ['Git', 'Apache/Nginx', 'Sécurité OWASP', 'SEO']]
];
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">À Propos de Moi</h1>
        <p class="lead text-muted">Découvrez mon parcours, mes compétences et mon expérience</p>
    </div>

    <!-- Bio Section -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h3 mb-4">Biographie</h2>
                    <p class="text-muted">Passionné par le développement web et les solutions numériques, je crée des expériences digitales modernes et performantes. Spécialisé dans la maintenance informatique, la configuration systèmes et l'infographie, je m'engage à livrer des projets de qualité qui répondent aux besoins de mes clients.</p>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <i class="bi bi-envelope text-primary me-2"></i>
                            <a href="mailto:<?= PERSONAL_INFO['email'] ?>" class="text-decoration-none"><?= PERSONAL_INFO['email'] ?></a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="bi bi-telephone text-primary me-2"></i>
                            <a href="tel:<?= PERSONAL_INFO['phone'] ?>" class="text-decoration-none"><?= PERSONAL_INFO['phone'] ?></a>
                        </div>
                        <div class="col-md-6">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            <?= PERSONAL_INFO['location'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h2 class="h4 mb-2"><?= PERSONAL_INFO['firstName'] ?></h2>
                    <h2 class="h4 mb-3"><?= PERSONAL_INFO['lastName'] ?></h2>
                    <p class="mb-4"><?= PERSONAL_INFO['title'] ?></p>
                    <span class="badge bg-white text-primary mb-4"><?= PERSONAL_INFO['availability'] ?></span>
                    <a href="#cv" class="btn btn-light w-100">
                        <i class="bi bi-download me-2"></i>Télécharger CV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Skills Section -->
    <div class="mb-5">
        <h2 class="display-6 fw-bold text-center mb-4">Compétences</h2>
        <div class="row g-4">
            <?php foreach ($skills as $skillGroup): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        <h3 class="h5 text-primary mb-3"><?= htmlspecialchars($skillGroup['category']) ?></h3>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($skillGroup['items'] as $skill): ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($skill) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CV Section -->
    <div id="cv">
        <h2 class="display-6 fw-bold text-center mb-4">Curriculum Vitae</h2>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span class="font-monospace small text-muted">cv.py</span>
                <div>
                    <span class="badge bg-danger rounded-circle p-1 me-1"></span>
                    <span class="badge bg-warning rounded-circle p-1 me-1"></span>
                    <span class="badge bg-success rounded-circle p-1"></span>
                </div>
            </div>
            <div class="card-body bg-dark text-light p-4">
                <pre class="mb-0"><code class="language-python"># Curriculum Vitae - Python Format

profile = {
    "nom": "<?= $cvData['profile']['nom'] ?>",
    "prenom": "<?= $cvData['profile']['prenom'] ?>",
    "titre": "<?= $cvData['profile']['titre'] ?>",
    "telephone": "<?= $cvData['profile']['telephone'] ?>",
    "email": "<?= $cvData['profile']['email'] ?>",
    "localisation": "<?= $cvData['profile']['localisation'] ?>"
}

competences = [
<?php foreach ($cvData['competences'] as $index => $comp): ?>
    "<?= $comp ?>"<?= $index < count($cvData['competences']) - 1 ? ',' : '' ?>

<?php endforeach; ?>
]</code></pre>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
