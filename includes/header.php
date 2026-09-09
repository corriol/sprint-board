<?php require_once __DIR__ . '/functions.php'; ?>
<!doctype html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($pageTitle ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark mb-4"><div class="container">
    <a class="navbar-brand fw-bold" href="index.php">SprintBoard</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
        <div class="d-flex gap-3 align-items-center">
            <a class="text-white" href="board.php">Tauler</a>
            <a class="text-white" href="teams.php">Equips</a>
            <a class="text-white" href="profile.php">Perfil</a>
            <form method="post" action="logout.php" class="m-0">
                <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">
                <button class="btn btn-outline-light btn-sm">Eixir</button>
            </form>
        </div>
    <?php endif; ?>
</div></nav>
<main class="container pb-5">
