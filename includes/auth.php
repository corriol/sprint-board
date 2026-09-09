<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';

function requireAuth(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function currentUser(): array
{
    return findRecord(loadData()['users'] ?? [], (int) ($_SESSION['user_id'] ?? 0)) ?? [];
}
