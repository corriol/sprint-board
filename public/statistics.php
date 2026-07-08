<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

// TODO: calcular nombre de tasques per estat
$taskCounts = $db->query("SELECT status, COUNT(*) as count FROM tasks GROUP BY status")->fetchAll();

// TODO: calcular tasques completades per equip
$completedByTeam = $db->query("
    SELECT te.name, COUNT(t.id) as count
    FROM tasks t
    JOIN teams te ON t.team_id = te.id
    WHERE t.status = 'done'
    GROUP BY te.name
")->fetchAll();

// TODO: calcular participació per alumne
$participation = $db->query("
    SELECT u.name, COUNT(t.id) as count
    FROM tasks t
    JOIN users u ON t.user_id = u.id
    GROUP BY u.name
    ORDER BY count DESC
")->fetchAll();

// TODO: mostrar percentatge de finalització de l'esprint
$sprintStats = $db->query("
    SELECT s.id, s.name, s.status,
        COUNT(t.id) as total_tasks,
        SUM(CASE WHEN t.status = 'done' THEN 1 ELSE 0 END) as done_tasks
    FROM sprints s
    LEFT JOIN tasks t ON t.sprint_id = s.id
    GROUP BY s.id
    ORDER BY s.start_date DESC
")->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<h1>Estadístiques</h1>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Tasques per estat</h3></div>
            <div class="card-body">
                <?php
                $statusMap = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
                $total = array_sum(array_column($taskCounts, 'count'));
                foreach ($taskCounts as $row):
                    $percent = $total > 0 ? round($row['count'] / $total * 100) : 0;
                ?>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span><?= h($statusMap[$row['status']] ?? $row['status']) ?></span>
                            <span><?= $row['count'] ?> tasques (<?= $percent ?>%)</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar <?= match($row['status']) { 'todo' => 'bg-secondary', 'in_progress' => 'bg-primary', 'done' => 'bg-success', default => '' } ?>"
                                 style="width: <?= $percent ?>%">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">Tasques completades per equip</h4></div>
            <div class="card-body">
                <?php if (empty($completedByTeam)): ?>
                    <p class="text-muted">No hi ha dades.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($completedByTeam as $row): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= h($row['name']) ?>
                                <span class="badge bg-success rounded-pill"><?= $row['count'] ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><h4 class="mb-0">Participació per alumne</h4></div>
            <div class="card-body">
                <?php if (empty($participation)): ?>
                    <p class="text-muted">No hi ha dades.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($participation as $row): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= h($row['name']) ?>
                                <span class="badge bg-info rounded-pill"><?= $row['count'] ?> tasques</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Percentatge de finalització per esprint</h3></div>
            <div class="card-body">
                <?php if (empty($sprintStats)): ?>
                    <p class="text-muted">No hi ha esprints.</p>
                <?php else: ?>
                    <?php foreach ($sprintStats as $s): ?>
                        <?php $percent = $s['total_tasks'] > 0 ? round($s['done_tasks'] / $s['total_tasks'] * 100) : 0; ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span><strong><?= h($s['name'])?></strong> (<?= h($s['status']) ?>)</span>
                                <span><?= $s['done_tasks'] ?> / <?= $s['total_tasks'] ?> tasques (<?= $percent ?>%)</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar <?= $percent === 100 ? 'bg-success' : ($percent > 0 ? 'bg-warning' : 'bg-secondary') ?>"
                                     style="width: <?= $percent ?>%">
                                    <?= $percent ?>%
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
