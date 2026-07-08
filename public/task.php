<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
    setFlash('error', 'No s\'ha especificat la tasca.');
    redirect('board.php');
}

$db = getDB();
$stmt = $db->prepare("
    SELECT t.*, u.name as user_name, te.name as team_name, s.name as sprint_name
    FROM tasks t
    LEFT JOIN users u ON t.user_id = u.id
    LEFT JOIN teams te ON t.team_id = te.id
    LEFT JOIN sprints s ON t.sprint_id = s.id
    WHERE t.id = ?
");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    setFlash('error', 'Tasca no trobada.');
    redirect('board.php');
}

$stmt = $db->prepare("
    SELECT c.*, u.name as user_name FROM comments c
    JOIN users u ON c.user_id = u.id
    WHERE c.task_id = ?
    ORDER BY c.created_at ASC
");
$stmt->execute([$id]);
$comments = $stmt->fetchAll();

$commentError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_comment') {
    requireCsrfToken();
    $content = trim($_POST['content'] ?? '');

    if ($content === '') {
        $commentError = 'El comentari no pot estar buit.';
    } else {
        $stmt = $db->prepare("INSERT INTO comments (task_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$id, currentUserId(), $content]);
        setFlash('success', 'Comentari afegit correctament.');
        redirect('task.php?id=' . $id);
    }
}

require __DIR__ . '/../includes/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <a href="board.php" class="btn btn-outline-secondary mb-3">← Tornar al tauler</a>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><?= h($task['title']) ?></h2>
                <?= getTaskStatusBadge($task['status']) ?>
            </div>
            <div class="card-body">
                <p><strong>Descripció:</strong></p>
                <p><?= h($task['description'] ?? 'Sense descripció.') ?></p>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Esprint:</strong> <?= h($task['sprint_name'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Equip:</strong> <?= h($task['team_name'] ?? '-') ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Responsable:</strong> <?= h($task['user_name'] ?? '-') ?></p>
                    </div>
                </div>
                <a href="task-edit.php?id=<?= $task['id'] ?>" class="btn btn-primary">Editar tasca</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Comentaris</h3></div>
            <div class="card-body">
                <?php if ($commentError): ?>
                    <div class="alert alert-danger"><?= h($commentError) ?></div>
                <?php endif; ?>

                <form method="post" class="mb-4">
                    <?= csrfField() ?>
                    <input type="hidden" name="action" value="add_comment">
                    <div class="mb-3">
                        <label for="content" class="form-label">Nou comentari</label>
                        <textarea class="form-control" id="content" name="content" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Afegir comentari</button>
                </form>

                <?php if (empty($comments)): ?>
                    <p class="text-muted">No hi ha comentaris.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <p class="mb-1"><?= h($comment['content']) ?></p>
                                <small class="text-muted">
                                    <?= h($comment['user_name']) ?> — <?= h($comment['created_at']) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
