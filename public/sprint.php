<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
    setFlash('error', 'No s\'ha especificat l\'esprint.');
    redirect('sprints.php');
}

$db = getDB();
$stmt = $db->prepare("SELECT * FROM sprints WHERE id = ?");
$stmt->execute([$id]);
$sprint = $stmt->fetch();

if (!$sprint) {
    setFlash('error', 'Esprint no trobat.');
    redirect('sprints.php');
}

$tasks = $db->prepare("
    SELECT t.*, u.name as user_name, te.name as team_name
    FROM tasks t
    LEFT JOIN users u ON t.user_id = u.id
    LEFT JOIN teams te ON t.team_id = te.id
    WHERE t.sprint_id = ?
    ORDER BY t.status, t.created_at
");
$tasks->execute([$id]);
$tasks = $tasks->fetchAll();

$members = $db->prepare("
    SELECT u.name, u.username, stm.role, te.name as team_name
    FROM sprint_team_members stm
    JOIN users u ON stm.user_id = u.id
    JOIN teams te ON stm.team_id = te.id
    WHERE stm.sprint_id = ?
    ORDER BY te.name, stm.role
");
$members->execute([$id]);
$members = $members->fetchAll();

$grouped = [];
foreach ($members as $m) {
    $grouped[$m['team_name']][] = $m;
}

require __DIR__ . '/../includes/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <a href="sprints.php" class="btn btn-outline-secondary mb-3">← Tornar a esprints</a>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?= h($sprint['name']) ?></h2>
                <?= getSprintStatusBadge($sprint['status']) ?>
            </div>
            <div class="card-body">
                <p><strong>Objectiu:</strong> <?= h($sprint['goal']) ?></p>
                <p><strong>Data d'inici:</strong> <?= h($sprint['start_date']) ?></p>
                <p><strong>Data de finalització:</strong> <?= h($sprint['end_date']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Membres per equip</h3></div>
            <div class="card-body">
                <?php if (empty($grouped)): ?>
                    <p class="text-muted">No hi ha membres assignats a este esprint.</p>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($grouped as $teamName => $teamMembers): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header"><strong><?= h($teamName) ?></strong></div>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($teamMembers as $m): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <?= h($m['name']) ?>
                                                <?= getRoleBadge($m['role']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Tasques</h3></div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <p class="text-muted">No hi ha tasques en este esprint.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Títol</th>
                                    <th>Equip</th>
                                    <th>Responsable</th>
                                    <th>Estat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><a href="task.php?id=<?= $task['id'] ?>"><?= h($task['title']) ?></a></td>
                                        <td><?= h($task['team_name'] ?? '-') ?></td>
                                        <td><?= h($task['user_name'] ?? '-') ?></td>
                                        <td><?= getTaskStatusBadge($task['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
