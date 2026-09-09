<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();
$data = loadData();
$sprint = activeSprint($data['sprints'] ?? []);
$errors = [];
$selectedTeam = (int) ($_GET['team_id'] ?? 0);

if ($selectedTeam !== 0 && findRecord($data['teams'] ?? [], $selectedTeam) === null) {
    $errors[] = 'L’equip seleccionat no existeix.';
    $selectedTeam = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validCsrf()) {
        $errors[] = 'La sessió no és vàlida. Torna a carregar el tauler.';
    }

    $newStatus = (string) ($_POST['status'] ?? '');
    if (!in_array($newStatus, ['todo', 'in_progress', 'done'], true)) {
        $errors[] = 'L’estat seleccionat no és vàlid.';
    }

    $taskFound = false;
    foreach ($data['tasks'] as &$task) {
        if (
            (int) $task['id'] === (int) ($_POST['task_id'] ?? 0)
            && $sprint !== null
            && (int) ($task['sprint_id'] ?? 0) === (int) $sprint['id']
        ) {
            $taskFound = true;
            if (!$errors) {
                $task['status'] = $newStatus;
            }
        }
    }
    unset($task);

    if (!$taskFound) {
        $errors[] = 'La tasca no existeix dins de l’esprint actiu.';
    }

    if (!$errors && saveData($data)) {
        redirect('board.php');
    }

    if (!$errors) {
        $errors[] = 'No s’ha pogut guardar el canvi d’estat.';
    }
}
$tasks = array_filter(
    $data['tasks'] ?? [],
    static fn (array $task): bool => $sprint !== null
        && (int) ($task['sprint_id'] ?? 0) === (int) $sprint['id']
        && ($selectedTeam === 0 || (int) ($task['team_id'] ?? 0) === $selectedTeam)
);
foreach ($tasks as &$task) {
    $task['team_name'] = recordName(
        $data['teams'],
        $task['team_id'] ?? null,
        'Sense equip'
    );
    $task['user_name'] = recordName(
        $data['users'],
        $task['user_id'] ?? null,
        'Sense responsable'
    );
}
unset($task);
$pageTitle = 'Tauler';
require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tauler Kanban</h1>
    <a class="btn btn-primary" href="task-create.php">+ Nova tasca</a>
</div>

<?php foreach ($errors as $error): ?>
    <div class="alert alert-danger"><?= h($error) ?></div>
<?php endforeach; ?>

<?php if (!$sprint): ?>
    <div class="alert alert-warning">No hi ha cap esprint actiu.</div>
<?php endif; ?>

<form method="get" class="row g-2 align-items-end mb-4">
    <div class="col-sm-5 col-md-4">
        <label class="form-label" for="team_id">Filtrar per equip</label>
        <select class="form-select" id="team_id" name="team_id">
            <option value="0">Tots els equips</option>
            <?php foreach ($data['teams'] ?? [] as $team): ?>
                <option value="<?= (int) $team['id'] ?>" <?= $selectedTeam === (int) $team['id'] ? 'selected' : '' ?>>
                    <?= h($team['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Filtrar</button></div>
</form>

<div class="row g-3">
    <?php foreach (['todo' => 'To do', 'in_progress' => 'In progress', 'done' => 'Done'] as $status => $label): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header fw-bold"><?= $label ?></div>
                <div class="card-body bg-light">
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] !== $status) continue; ?>
                        <article class="card mb-3">
                            <div class="card-body">
                                <h2 class="h6">
                                    <a href="task.php?id=<?= $task['id'] ?>">
                                        <?= h($task['title']) ?>
                                    </a>
                                </h2>
                                <p class="small mb-2">
                                    <?= h($task['description']) ?>
                                </p>
                                <small class="text-muted">
                                    <?= h($task['team_name']) ?> · <?= h($task['user_name']) ?>
                                </small>
                                <form method="post" class="mt-2">
                                    <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">
                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="todo" <?= $status === 'todo' ? 'selected' : '' ?>>To do</option>
                                        <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                                        <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>Done</option>
                                    </select>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
