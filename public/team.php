<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$team = findRecord($data['teams'], (int) ($_GET['id'] ?? 0));
$sprint = activeSprint($data['sprints'] ?? []);

if (!$team) {
    http_response_code(404);
    exit('Equip no trobat');
}

$members = [];
foreach ($data['team_members'] ?? [] as $membership) {
    if (
        (int) $membership['team_id'] === (int) $team['id']
        && ($sprint === null || (int) ($membership['sprint_id'] ?? 0) === (int) $sprint['id'])
    ) {
        $member = findRecord($data['users'], (int) $membership['user_id']);
        if ($member) {
            $members[] = [
                'user' => $member,
                'role' => $membership['role'],
            ];
        }
    }
}

$pageTitle = $team['name'];
require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">FITXA D’EQUIP</p>
        <h1><?= h($team['name']) ?></h1>
    </div>
    <a class="btn btn-outline-secondary" href="teams.php">Tornar als equips</a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="h5 mb-0">Membres</h2>
    </div>
    <div class="card-body">
        <?php if (!$members): ?>
            <p class="text-muted mb-0">Aquest equip encara no té membres.</p>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($members as $member): ?>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <div>
                            <strong><?= h($member['user']['name']) ?></strong><br>
                            <small class="text-muted">
                                <?= h($member['user']['email']) ?>
                            </small>
                        </div>
                        <span class="badge text-bg-secondary align-self-center">
                            <?= h($member['role']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
