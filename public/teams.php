<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$pageTitle = 'Equips';
require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">COL·LABORACIÓ</p>
        <h1>Equips</h1>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($data['teams'] as $team): ?>
        <?php
        $memberCount = 0;
        foreach ($data['team_members'] ?? [] as $membership) {
            if ((int) $membership['team_id'] === (int) $team['id']) {
                $memberCount++;
            }
        }
        ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h4"><?= h($team['name']) ?></h2>
                    <p class="text-muted"><?= $memberCount ?> membre(s)</p>
                    <a class="btn btn-outline-primary" href="team.php?id=<?= $team['id'] ?>">
                        Veure fitxa
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
