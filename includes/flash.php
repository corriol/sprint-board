<?php

function setFlash(string $type, string $message): void {
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function getFlashes(): array {
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

function hasFlashes(): bool {
    return !empty($_SESSION['flash']);
}

function renderFlashes(): void {
    foreach (getFlashes() as $flash) {
        $alertClass = match ($flash['type']) {
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
            default => 'alert-secondary',
        };
        echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">';
        echo h($flash['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
}
