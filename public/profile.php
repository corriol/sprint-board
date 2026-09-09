<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$user = currentUser();
$pageTitle = 'Perfil';
require __DIR__ . '/../includes/header.php';
?>

<h1>Perfil</h1>

<div class="card card-body col-md-6">
    <h2 class="h4"><?= h($user['name']) ?></h2>
    <p class="mb-1"><?= h($user['email']) ?></p>
    <span class="badge text-bg-secondary align-self-start">
        <?= h($user['role']) ?>
    </span>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
