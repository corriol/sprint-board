<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h(APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php"><?= h(APP_NAME) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isAuthenticated()): ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="sprints.php">Esprints</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teams.php">Equips</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="board.php">Tauler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="task-create.php">Nova Tasca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="evidences.php">Evidències</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="statistics.php">Estadístiques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="history.php">Històric</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><?= h(currentUserName()) ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Tancar sessió</a>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container">
    <?php renderFlashes(); ?>
