<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();
$teams = $db->query("SELECT * FROM teams ORDER BY name")->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<h1>Equips</h1>

<?php if (empty($teams)): ?>
    <p class="text-muted">No hi ha equips definits.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($teams as $team):
            $stmt = $db->prepare("
                SELECT u.*, tm.role FROM team_members tm
                JOIN users u ON tm.user_id = u.id
                WHERE tm.team_id = ?
            ");
            $stmt->execute([$team['id']]);
            $members = $stmt->fetchAll();
        ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0"><?= h($team['name']) ?></h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($members)): ?>
                            <p class="text-muted">Sense membres.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($members as $m): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= h($m['name']) ?>
                                        <?= getRoleBadge($m['role']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <a href="team.php?id=<?= $team['id'] ?>" class="btn btn-primary mt-3">Veure equip</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
