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
$values = ['title' => '', 'description' => ''];

if (!$sprint) {
    $errors[] = 'No hi ha cap esprint actiu per a crear tasques.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['title'] = trim((string) ($_POST['title'] ?? ''));
    $values['description'] = trim((string) ($_POST['description'] ?? ''));
    if (!validCsrf()) $errors[] = 'La sessió no és vàlida.';
    if ($values['title'] === '') $errors[] = 'El títol és obligatori.';
    if ($values['description'] === '') $errors[] = 'La descripció és obligatòria.';
    if (!$errors) {
        $data['tasks'][] = [
            'id' => $data['next_ids']['tasks']++,
            'title' => $values['title'],
            'description' => $values['description'],
            'status' => 'todo',
            'user_id' => $_SESSION['user_id'],
            'sprint_id' => $sprint['id'],
            'team_id' => null,
        ];

        if (saveData($data)) {
            redirect('board.php');
        }

        $errors[] = 'No s’ha pogut guardar la tasca. Intenta-ho de nou.';
    }
}
$pageTitle = 'Nova tasca';
require __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Nova tasca</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endforeach; ?>

        <form method="post" class="card card-body">
            <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">

            <label class="form-label">Títol</label>
            <input class="form-control mb-3" name="title" value="<?= h($values['title']) ?>" required>

            <label class="form-label">Descripció</label>
            <textarea class="form-control mb-3" name="description" rows="4" required><?= h($values['description']) ?></textarea>

            <button class="btn btn-primary" <?= !$sprint ? 'disabled' : '' ?>>Crear tasca</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
