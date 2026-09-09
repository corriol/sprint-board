<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];
$values = ['name' => '', 'email' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name'] = trim((string) ($_POST['name'] ?? ''));
    $values['email'] = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');
    $data = loadData();

    if ($values['name'] === '') $errors[] = 'El nom és obligatori.';
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El correu no és vàlid.';
    foreach ($data['users'] as $user) {
        if (strtolower($user['email']) === $values['email']) $errors[] = 'Aquest correu ja està registrat.';
    }
    if (strlen($password) < 8) $errors[] = 'La contrasenya ha de tindre almenys 8 caràcters.';
    if ($password !== $confirmation) $errors[] = 'Les contrasenyes no coincideixen.';

    if (!validCsrf()) $errors[] = 'La sessió no és vàlida. Torna a carregar el formulari.';

    if (!$errors) {
        $ids = array_column($data['users'], 'id');
        $data['users'][] = ['id' => $ids ? max($ids) + 1 : 1, 'name' => $values['name'], 'email' => $values['email'], 'password' => password_hash($password, PASSWORD_DEFAULT), 'role' => 'student'];
        if (saveData($data)) {
            redirect('login.php?registered=1');
        }

        $errors[] = 'No s’ha pogut guardar el compte. Intenta-ho de nou.';
    }
}
$pageTitle = 'Crear compte';
require __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h1>Crear compte</h1>
        <p class="text-muted">Els nous comptes es creen amb el rol d’estudiant.</p>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endforeach; ?>

        <form method="post" class="card card-body">
            <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">
            <label class="form-label">Nom</label>
            <input class="form-control mb-3" name="name" value="<?= h($values['name']) ?>" required>

            <label class="form-label">Correu</label>
            <input class="form-control mb-3" type="email" name="email" value="<?= h($values['email']) ?>" required>

            <label class="form-label">Contrasenya</label>
            <input class="form-control mb-3" type="password" name="password" minlength="8" required>

            <label class="form-label">Repeteix la contrasenya</label>
            <input class="form-control mb-3" type="password" name="password_confirmation" minlength="8" required>

            <button class="btn btn-primary">Registrar-me</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
