<?php

function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . generateCsrfToken() . '">';
}

function requireCsrfToken(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($token)) {
        setFlash('error', 'El token CSRF no és vàlid. Torna a intentar-ho.');
        redirect($_SERVER['HTTP_REFERER'] ?? 'index.php');
    }
}
