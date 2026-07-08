<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

$teamFilter = $_GET['team'] ?? '';

$where = '';
$params = [];
if ($teamFilter !== '') {
    $where = "WHERE t.team_id = ?";
    $params[] = $teamFilter;
}

$stmt = $db->prepare("
    SELECT t.*, u.name as user_name, te.name as team_name
    FROM tasks t
    LEFT JOIN users u ON t.user_id = u.id
    LEFT JOIN teams te ON t.team_id = te.id
    $where
    ORDER BY t.created_at DESC
");
$stmt->execute($params);
$tasks = $stmt->fetchAll();

$teams = $db->query("SELECT * FROM teams ORDER BY name")->fetchAll();

$columns = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
$board = ['todo' => [], 'in_progress' => [], 'done' => []];
foreach ($tasks as $task) {
    $board[$task['status']][] = $task;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'move_task') {
    requireCsrfToken();
    $taskId = $_POST['task_id'] ?? null;
    $newStatus = $_POST['new_status'] ?? null;

    if (in_array($newStatus, ['todo', 'in_progress', 'done'])) {
        $stmt = $db->prepare("UPDATE tasks SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$newStatus, $taskId]);
        setFlash('success', 'Tasca moguda correctament.');
    } else {
        setFlash('error', 'Estat no vàlid.');
    }
    redirect('board.php' . ($teamFilter ? "?team=$teamFilter" : ''));
}

require __DIR__ . '/../includes/header.php';
?>

<h1>Tauler Kanban</h1>

<form method="get" class="row g-3 mb-4">
    <div class="col-auto">
        <label for="team" class="form-label">Filtra per equip:</label>
    </div>
    <div class="col-auto">
        <select name="team" id="team" class="form-select" onchange="this.form.submit()">
            <option value="">Tots els equips</option>
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team['id'] ?>" <?= $teamFilter == $team['id'] ? 'selected' : '' ?>>
                    <?= h($team['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php if ($teamFilter): ?>
        <div class="col-auto">
            <a href="board.php" class="btn btn-outline-secondary">Netejar filtre</a>
        </div>
    <?php endif; ?>
</form>

<div class="row">
    <?php foreach ($columns as $status => $label): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header <?= match($status) { 'todo' => 'bg-secondary text-white', 'in_progress' => 'bg-primary text-white', 'done' => 'bg-success text-white' } ?>">
                    <h4 class="mb-0"><?= h($label) ?></h4>
                </div>
                <div class="card-body">
                    <?php if (empty($board[$status])): ?>
                        <p class="text-muted">No hi ha tasques.</p>
                    <?php else: ?>
                        <?php foreach ($board[$status] as $task): ?>
                            <div class="card mb-2 border">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-1">
                                        <a href="task.php?id=<?= $task['id'] ?>" class="text-decoration-none">
                                            <?= h($task['title']) ?>
                                        </a>
                                    </h6>
                                    <p class="card-text small text-muted mb-1">
                                        <?= h(substr($task['description'] ?? '', 0, 80)) ?><?= strlen($task['description'] ?? '') > 80 ? '...' : '' ?>
                                    </p>
                                    <p class="card-text small mb-1">
                                        <strong>Equip:</strong> <?= h($task['team_name'] ?? '-') ?>
                                        <br>
                                        <strong>Responsable:</strong> <?= h($task['user_name'] ?? '-') ?>
                                    </p>
                                    <?php if ($status !== 'done'): ?>
                                        <form method="post" class="d-inline">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="action" value="move_task">
                                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                            <select name="new_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="">Canviar estat...</option>
                                                <?php if ($status === 'todo'): ?>
                                                    <option value="in_progress">→ In Progress</option>
                                                <?php elseif ($status === 'in_progress'): ?>
                                                    <option value="todo">← To Do</option>
                                                    <option value="done">→ Done</option>
                                                <?php endif; ?>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                    <a href="task-edit.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary mt-1">Editar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
