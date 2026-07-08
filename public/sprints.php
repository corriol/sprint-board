<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();
$sprints = $db->query("SELECT * FROM sprints ORDER BY start_date DESC")->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<h1>Esprints</h1>

<?php if (empty($sprints)): ?>
    <p class="text-muted">No hi ha esprints definits.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($sprints as $sprint): ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><?= h($sprint['name']) ?></h3>
                        <?= getSprintStatusBadge($sprint['status']) ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Objectiu:</strong> <?= h($sprint['goal']) ?></p>
                        <p><strong>Dates:</strong> <?= h($sprint['start_date']) ?> → <?= h($sprint['end_date']) ?></p>
                        <a href="sprint.php?id=<?= $sprint['id'] ?>" class="btn btn-primary">Veure detalls</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../includes/footer.php'; ?>
