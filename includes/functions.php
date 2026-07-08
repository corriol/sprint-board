<?php

function h(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function old(string $key, mixed $default = ''): mixed {
    return $_SESSION['old'][$key] ?? $default;
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function getSprintStatusBadge(string $status): string {
    return match ($status) {
        'active' => '<span class="badge bg-success">Actiu</span>',
        'completed' => '<span class="badge bg-secondary">Finalitzat</span>',
        default => '<span class="badge bg-warning text-dark">Pendent</span>',
    };
}

function getTaskStatusBadge(string $status): string {
    return match ($status) {
        'todo' => '<span class="badge bg-secondary">To Do</span>',
        'in_progress' => '<span class="badge bg-primary">In Progress</span>',
        'done' => '<span class="badge bg-success">Done</span>',
        default => '<span class="badge bg-secondary">' . h($status) . '</span>',
    };
}

function getRoleBadge(string $role): string {
    return match ($role) {
        'scrum_master' => '<span class="badge bg-danger">Scrum Master</span>',
        'reviewer' => '<span class="badge bg-info text-dark">Reviewer</span>',
        default => '<span class="badge bg-light text-dark">Developer</span>',
    };
}
