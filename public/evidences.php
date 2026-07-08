<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

$tasks = $db->query("
    SELECT t.id, t.title, s.name as sprint_name
    FROM tasks t
    JOIN sprints s ON t.sprint_id = s.id
    ORDER BY s.start_date DESC, t.title
")->fetchAll();

$evidences = $db->query("
    SELECT e.*, t.title as task_title, u.name as user_name
    FROM evidences e
    JOIN tasks t ON e.task_id = t.id
    JOIN users u ON e.user_id = u.id
    ORDER BY e.created_at DESC
")->fetchAll();

// TODO: permetre pujar una evidència associada a una tasca
// TODO: mostrar les evidències d'una tasca
// TODO: validar el tipus de fitxer

require __DIR__ . '/../includes/header.php';
?>

<h1>Evidències</h1>

<div class="alert alert-info">
    <strong>Nota:</strong> Esta pàgina està en construcció. L'alumnat ha d'implementar:
    <ul class="mb-0 mt-1">
        <li>Formulari per pujar fitxers d'evidència associats a una tasca.</li>
        <li>Validació del tipus de fitxer (PDF, imatges, etc.).</li>
        <Llistat de les evidències de cada tasca.</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Tasques disponibles</h3></div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($tasks as $task): ?>
                        <li class="list-group-item">
                            <a href="task.php?id=<?= $task['id'] ?>"><?= h($task['title']) ?></a>
                            <small class="text-muted"> — <?= h($task['sprint_name']) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h3 class="mb-0">Evidències pujades</h3></div>
            <div class="card-body">
                <?php if (empty($evidences)): ?>
                    <p class="text-muted">No hi ha evidències pujades.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($evidences as $ev): ?>
                            <li class="list-group-item">
                                <strong><?= h($ev['original_filename']) ?></strong><br>
                                <small>Tasca: <?= h($ev['task_title']) ?> — Pujat per <?= h($ev['user_name']) ?> (<?= h($ev['created_at']) ?>)</small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
