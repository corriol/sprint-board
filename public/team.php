<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
    setFlash('error', 'No s\'ha especificat l\'equip.');
    redirect('teams.php');
}

$db = getDB();
$stmt = $db->prepare("SELECT * FROM teams WHERE id = ?");
$stmt->execute([$id]);
$team = $stmt->fetch();

if (!$team) {
    setFlash('error', 'Equip no trobat.');
    redirect('teams.php');
}

$stmt = $db->prepare("
    SELECT u.*, tm.role FROM team_members tm
    JOIN users u ON tm.user_id = u.id
    WHERE tm.team_id = ?
");
$stmt->execute([$id]);
$members = $stmt->fetchAll();

$stmt = $db->prepare("
    SELECT t.*, s.name as sprint_name, s.status as sprint_status
    FROM tasks t
    JOIN sprints s ON t.sprint_id = s.id
    WHERE t.team_id = ?
    ORDER BY s.start_date DESC, t.created_at DESC
");
$stmt->execute([$id]);
$tasks = $stmt->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <a href="teams.php" class="btn btn-outline-secondary mb-3">← Tornar a equips</a>
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0"><?= h($team['name']) ?></h2>
            </div>
            <div class="card-body">
                <h3>Membres</h3>
                <?php if (empty($members)): ?>
                    <p class="text-muted">No hi ha membres en este equip.</p>
                <?php else: ?>
                    <ul class="list-group mb-3">
                        <?php foreach ($members as $m): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= h($m['name']) ?>
                                <?= getRoleBadge($m['role']) ?>
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
            <div class="card-header"><h3 class="mb-0">Tasques de l'equip</h3></div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <p class="text-muted">No hi ha tasques assignades a este equip.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Títol</th>
                                    <th>Esprint</th>
                                    <th>Estat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><a href="task.php?id=<?= $task['id'] ?>"><?= h($task['title']) ?></a></td>
                                        <td><?= h($task['sprint_name']) ?></td>
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
