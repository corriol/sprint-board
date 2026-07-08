<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

$activeSprint = $db->query("SELECT * FROM sprints WHERE status = 'active' LIMIT 1")->fetch();

$taskCounts = $db->query("
    SELECT status, COUNT(*) as count FROM tasks GROUP BY status
")->fetchAll();

$teamCount = $db->query("SELECT COUNT(*) FROM teams")->fetchColumn();
$userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$sprintCount = $db->query("SELECT COUNT(*) FROM sprints")->fetchColumn();

require __DIR__ . '/../includes/header.php';
?>

<div class="row">
    <div class="col-12 mb-4">
        <h1>Benvingut/da, <?= h(currentUserName()) ?></h1>
        <p class="text-muted">Rol: <?= h(currentUserRole()) ?></p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h5 class="card-title">Esprints</h5>
                <p class="display-6"><?= $sprintCount ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">Equips</h5>
                <p class="display-6"><?= $teamCount ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-bg-info">
            <div class="card-body">
                <h5 class="card-title">Usuaris</h5>
                <p class="display-6"><?= $userCount ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Tasques</h5>
                <p class="display-6"><?= array_sum(array_column($taskCounts, 'count')) ?></p>
            </div>
        </div>
    </div>
</div>

<?php if ($activeSprint): ?>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Esprint actiu: <?= h($activeSprint['name']) ?></h3>
        <?= getSprintStatusBadge($activeSprint['status']) ?>
    </div>
    <div class="card-body">
        <p><strong>Objectiu:</strong> <?= h($activeSprint['goal']) ?></p>
        <p><strong>Dates:</strong> <?= h($activeSprint['start_date']) ?> → <?= h($activeSprint['end_date']) ?></p>
        <a href="sprint.php?id=<?= $activeSprint['id'] ?>" class="btn btn-primary">Veure esprint</a>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">Tasques per estat</h4></div>
            <div class="card-body">
                <?php
                $statusMap = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
                foreach ($taskCounts as $row): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?= h($statusMap[$row['status']] ?? $row['status']) ?></span>
                        <span class="badge bg-secondary"><?= $row['count'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">Accions ràpides</h4></div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="board.php" class="btn btn-outline-primary">Anar al tauler Kanban</a>
                    <a href="task-create.php" class="btn btn-outline-success">Crear nova tasca</a>
                    <a href="sprints.php" class="btn btn-outline-secondary">Veure tots els esprints</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
