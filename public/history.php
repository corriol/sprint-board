<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

$sprints = $db->query("SELECT * FROM sprints ORDER BY start_date DESC")->fetchAll();

// TODO: mostrar quin rol ha tingut cada alumne en cada esprint
// TODO: mostrar quantes tasques ha completat cada alumne

require __DIR__ . '/../includes/header.php';
?>

<h1>Històric d'esprints</h1>

<div class="alert alert-info">
    <strong>Nota:</strong> Esta pàgina està en construcció. L'alumnat ha d'implementar:
    <ul class="mb-0 mt-1">
        <li>Mostrar el rol de cada alumne en cada esprint.</li>
        <li>Mostrar quantes tasques ha completat cada alumne per esprint.</li>
    </ul>
</div>

<?php if (empty($sprints)): ?>
    <p class="text-muted">No hi ha esprints.</p>
<?php else: ?>
    <?php foreach ($sprints as $sprint):
        $stmt = $db->prepare("
            SELECT u.name, u.username, stm.role, te.name as team_name
            FROM sprint_team_members stm
            JOIN users u ON stm.user_id = u.id
            JOIN teams te ON stm.team_id = te.id
            WHERE stm.sprint_id = ?
            ORDER BY te.name, u.name
        ");
        $stmt->execute([$sprint['id']]);
        $members = $stmt->fetchAll();

        $stmt = $db->prepare("
            SELECT COUNT(*) as total FROM tasks WHERE sprint_id = ?
        ");
        $stmt->execute([$sprint['id']]);
        $totalTasks = $stmt->fetchColumn();

        $stmt = $db->prepare("
            SELECT COUNT(*) as done FROM tasks WHERE sprint_id = ? AND status = 'done'
        ");
        $stmt->execute([$sprint['id']]);
        $doneTasks = $stmt->fetchColumn();
    ?>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= h($sprint['name']) ?></h3>
                <?= getSprintStatusBadge($sprint['status']) ?>
            </div>
            <div class="card-body">
                <p><strong>Objectiu:</strong> <?= h($sprint['goal']) ?></p>
                <p><strong>Dates:</strong> <?= h($sprint['start_date']) ?> → <?= h($sprint['end_date']) ?></p>
                <p><strong>Tasques:</strong> <?= $doneTasks ?> / <?= $totalTasks ?> completades</p>

                <?php if (!empty($members)): ?>
                    <h4>Membres</h4>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Equip</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $m): ?>
                                <tr>
                                    <td><?= h($m['name']) ?></td>
                                    <td><?= h($m['team_name']) ?></td>
                                    <td><?= getRoleBadge($m['role']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <a href="sprint.php?id=<?= $sprint['id'] ?>" class="btn btn-primary btn-sm">Veure detalls</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
