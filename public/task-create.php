<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/flash.php';

session_start();
requireAuth();

$db = getDB();

$teams = $db->query("SELECT * FROM teams ORDER BY name")->fetchAll();
$users = $db->query("SELECT * FROM users ORDER BY name")->fetchAll();
$sprints = $db->query("SELECT * FROM sprints ORDER BY start_date DESC")->fetchAll();

$title = '';
$description = '';
$teamId = '';
$userId = '';
$sprintId = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrfToken();

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $teamId = $_POST['team_id'] ?? '';
    $userId = $_POST['user_id'] ?? '';
    $sprintId = $_POST['sprint_id'] ?? '';

    if ($title === '') {
        $errors[] = 'El títol de la tasca és obligatori.';
    }
    if ($sprintId === '') {
        $errors[] = 'Has de seleccionar un esprint.';
    }

    if (empty($errors)) {
        $stmt = $db->prepare("
            INSERT INTO tasks (title, description, status, team_id, user_id, sprint_id)
            VALUES (?, ?, 'todo', ?, ?, ?)
        ");
        $stmt->execute([$title, $description, $teamId ?: null, $userId ?: null, $sprintId]);
        setFlash('success', 'Tasca creada correctament.');
        redirect('board.php');
    }

    $_SESSION['old'] = $_POST;
}

require __DIR__ . '/../includes/header.php';
?>

<h1>Nova tasca</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= h($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post">
    <?= csrfField() ?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="title" class="form-label">Títol *</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= h(old('title', $title)) ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="sprint_id" class="form-label">Esprint *</label>
            <select class="form-select" id="sprint_id" name="sprint_id" required>
                <option value="">Selecciona un esprint...</option>
                <?php foreach ($sprints as $sprint): ?>
                    <option value="<?= $sprint['id'] ?>" <?= old('sprint_id', $sprintId) == $sprint['id'] ? 'selected' : '' ?>>
                        <?= h($sprint['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descripció</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= h(old('description', $description)) ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="team_id" class="form-label">Equip</label>
            <select class="form-select" id="team_id" name="team_id">
                <option value="">Sense equip</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= $team['id'] ?>" <?= old('team_id', $teamId) == $team['id'] ? 'selected' : '' ?>>
                        <?= h($team['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="user_id" class="form-label">Responsable</label>
            <select class="form-select" id="user_id" name="user_id">
                <option value="">Sense responsable</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= old('user_id', $userId) == $user['id'] ? 'selected' : '' ?>>
                        <?= h($user['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Crear tasca</button>
    <a href="board.php" class="btn btn-secondary">Cancel·lar</a>
</form>

<?php require __DIR__ . '/../includes/footer.php'; ?>
