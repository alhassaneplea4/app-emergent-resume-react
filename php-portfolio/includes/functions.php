<?php
declare(strict_types=1);

/**
 * Sanitize input to prevent XSS
 */
function sanitize_input(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email format
 */
function validate_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate CSRF token
 */
function generate_csrf_token(): string {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verify_csrf_token(string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check rate limiting
 */
function check_rate_limit(): bool {
    $ip = $_SERVER['REMOTE_ADDR'];
    $key = 'rate_limit_' . md5($ip);
    $now = time();
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }
    
    // Remove old entries
    $_SESSION[$key] = array_filter($_SESSION[$key], function($timestamp) use ($now) {
        return ($now - $timestamp) < RATE_LIMIT_WINDOW;
    });
    
    // Check if limit exceeded
    if (count($_SESSION[$key]) >= RATE_LIMIT_MAX) {
        return false;
    }
    
    // Add current request
    $_SESSION[$key][] = $now;
    return true;
}

/**
 * Send email using PHP mail function (fallback if PHPMailer not available)
 */
function send_contact_email_simple(string $name, string $email, string $subject, string $message): bool {
    $to = SMTP_FROM_EMAIL;
    $email_subject = "Nouveau message - " . $subject;
    $email_body = "Nouveau message de contact reçu :\n\n";
    $email_body .= "Nom: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Sujet: $subject\n\n";
    $email_body .= "Message:\n$message\n\n";
    $email_body .= "---\n";
    $email_body .= "Envoyé depuis votre portfolio professionnel\n";
    $email_body .= "Date: " . date('d/m/Y à H:i');
    
    $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    return mail($to, $email_subject, $email_body, $headers);
}

/**
 * Get current page name
 */
function get_current_page(): string {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page === 'index' ? 'home' : $page;
}

/**
 * Check if page is active
 */
function is_active(string $page): bool {
    return get_current_page() === $page;
}

/**
 * Set flash message
 */
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get and clear flash message
 */
function get_flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
