<?php
declare(strict_types=1);
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Contact - ' . SITE_NAME;
$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $errors[] = 'Token de sécurité invalide.';
    }
    
    // Honeypot check
    if (!empty($_POST['website'])) {
        $errors[] = 'Spam détecté.';
    }
    
    // Check rate limiting
    if (!check_rate_limit()) {
        $errors[] = 'Trop de requêtes. Veuillez réessayer dans 15 minutes.';
    }
    
    if (empty($errors)) {
        // Sanitize inputs
        $name = sanitize_input($_POST['name'] ?? '');
        $email = sanitize_input($_POST['email'] ?? '');
        $subject = sanitize_input($_POST['subject'] ?? '');
        $message = sanitize_input($_POST['message'] ?? '');
        
        // Validate inputs
        if (empty($name) || strlen($name) > 255) {
            $errors[] = 'Le nom est requis (max 255 caractères).';
        }
        
        if (empty($email) || !validate_email($email)) {
            $errors[] = 'Email invalide.';
        }
        
        if (empty($subject) || strlen($subject) > 255) {
            $errors[] = 'Le sujet est requis (max 255 caractères).';
        }
        
        if (empty($message) || strlen($message) > 2000) {
            $errors[] = 'Le message est requis (max 2000 caractères).';
        }
        
        // If no errors, save to database and send email
        if (empty($errors)) {
            try {
                $db = getDBConnection();
                
                // Prepare SQL statement
                $stmt = $db->prepare(
                    'INSERT INTO contacts (name, email, subject, message, ip_address, user_agent) '
                    . 'VALUES (:name, :email, :subject, :message, :ip, :ua)'
                );
                
                // Execute with parameters
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':subject' => $subject,
                    ':message' => $message,
                    ':ip' => $_SERVER['REMOTE_ADDR'],
                    ':ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
                ]);
                
                // Try to send email (non-blocking)
                $email_sent = send_contact_email_simple($name, $email, $subject, $message);
                
                if (!$email_sent) {
                    error_log('Email notification failed for contact from: ' . $email);
                }
                
                set_flash('success', 'Message envoyé avec succès!');
                header('Location: contact.php');
                exit;
                
            } catch (PDOException $e) {
                error_log('Database error: ' . $e->getMessage());
                $errors[] = 'Une erreur s\'est produite. Veuillez réessayer.';
            }
        }
    }
}

// Generate CSRF token
$csrf_token = generate_csrf_token();

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Contactez-moi</h1>
        <p class="lead text-muted">Une question ou un projet ? N'hésitez pas à me contacter. Je vous répondrai dans les plus brefs délais.</p>
    </div>

    <div class="row g-4">
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">Envoyez-moi un message</h2>
                    
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="contact.php" id="contactForm">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <!-- Honeypot field (hidden) -->
                        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom complet *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       required 
                                       maxlength="255"
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       maxlength="255"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Objet *</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="subject" 
                                       name="subject" 
                                       required 
                                       maxlength="255"
                                       value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" 
                                          id="message" 
                                          name="message" 
                                          rows="6" 
                                          required 
                                          maxlength="2000"><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-send me-2"></i>Envoyer le message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="h5 mb-4">Informations de Contact</h3>
                    <div class="mb-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-2 mb-2 d-inline-block">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h4 class="h6 mb-1">Email</h4>
                        <a href="mailto:<?= PERSONAL_INFO['email'] ?>" class="text-decoration-none"><?= PERSONAL_INFO['email'] ?></a>
                    </div>
                    <div class="mb-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-2 mb-2 d-inline-block">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h4 class="h6 mb-1">Téléphone</h4>
                        <a href="tel:<?= PERSONAL_INFO['phone'] ?>" class="text-decoration-none"><?= PERSONAL_INFO['phone'] ?></a>
                    </div>
                    <div>
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-2 mb-2 d-inline-block">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h4 class="h6 mb-1">Localisation</h4>
                        <p class="mb-0"><?= PERSONAL_INFO['location'] ?></p>
                    </div>
                </div>
            </div>
            
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="h5 mb-3">Disponibilité</h3>
                    <p class="mb-3"><?= PERSONAL_INFO['availability'] ?></p>
                    <p class="small mb-0">Je suis actuellement à la recherche de nouvelles opportunités professionnelles et de stages pour continuer à développer mes compétences.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
